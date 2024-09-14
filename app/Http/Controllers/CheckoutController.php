<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CartItem;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    private $paypalClient;

    // Initialize PayPal client in constructor
    public function __construct()
    {
        $environment = new SandboxEnvironment(
            env('PAYPAL_CLIENT_ID'),
            env('PAYPAL_SECRET_KEY')
        );
        $this->paypalClient = new PayPalHttpClient($environment);
    }

    // Display the checkout page
    public function showCheckout()
    {
        $user_id = auth()->id();
        $cartItems = $this->getCartItems($user_id);

        $subtotal = $this->calculateSubtotal($cartItems);
        $discount = session('discount', 0);
        $total = $subtotal - $discount;
        $isCartEmpty = $cartItems->isEmpty();

        return view('checkout.checkout', compact('cartItems', 'subtotal', 'discount', 'total', 'isCartEmpty'));
    }

    // Retrieve cart items for a user
    private function getCartItems($user_id)
    {
        $items = CartItem::where('user_id', $user_id)->get();
        if (!$items instanceof Collection) {
            Log::error('Cart Items is not a collection: ' . gettype($items));
            throw new \Exception('Cart items should be a collection.');
        }
        return $items;
    }

    // Calculate the subtotal for cart items
    private function calculateSubtotal(Collection $cartItems)
    {
        return $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    // Handle the store order request
    public function store(Request $request)
    {
        Log::info('Payment Method: ' . $request->input('payment_method'));
    
        $user = auth()->user();
    
        if (!$user->phone) {
            return redirect()->route('setting') 
                ->with('warning', 'Please update your phone before proceeding with payment.');
        }
    
        $this->validateCheckoutForm($request);
        $order = $this->createOrder($request);
    
        return $this->processPayment($order);
    }
    

    // Validate the checkout form
    private function validateCheckoutForm(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'post_code' => 'required|string|max:20',
            'payment_method' => 'required|string|in:stripe,paypal',
        ]);
    }

    // Create a new order
    private function createOrder(Request $request)
    {
        $user = auth()->user();
        $cartItems = $this->getCartItems($user->id);

        if (!$cartItems instanceof Collection) {
            Log::error('Cart Items is not a collection: ' . gettype($cartItems));
            throw new \Exception('Cart items should be a collection.');
        }

        $subtotal = $this->calculateSubtotal($cartItems);
        $discount = session('discount', 0);
        $totalAmount = $subtotal - $discount;

        $order = new Order([
            'order_number' => uniqid('ORDER-'),
            'user_id' => $user->id,
            'sub_total' => $subtotal,
            'total_amount' => $totalAmount,
            'quantity' => $cartItems->sum('quantity'),
            'payment_method' => $request->input('payment_method'),
            'payment_status' => 'unpaid',
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $user->email,
            'phone' => $user->phone,
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'post_code' => $request->input('post_code'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
        ]);

        $order->save();
        return $order;
    }

    // Process payment based on method
    private function processPayment(Order $order)
    {
        Log::info('Processing payment for method: ' . $order->payment_method);

        if ($order->payment_method == 'stripe') {
            return $this->processStripePayment($order);
        } elseif ($order->payment_method == 'paypal') {
            return $this->processPayPalPayment($order);
        }

        throw new \Exception('Invalid payment method');
    }

    // Handle Stripe payment process
    private function processStripePayment(Order $order)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Order #' . $order->order_number,
                    ],
                    'unit_amount' => $order->total_amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['order' => $order->id]),
            'cancel_url' => route('checkout.cancel', ['order' => $order->id]),
        ]);

        return redirect($session->url);
    }

    // Handle PayPal payment process
    private function processPayPalPayment(Order $order)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => number_format($order->total_amount, 2),
                ],
                'description' => 'Payment for Order #' . $order->order_number,
            ]],
            'application_context' => [
                'return_url' => route('checkout.success', ['order' => $order->id]),
                'cancel_url' => route('checkout.cancel', ['order' => $order->id]),
            ],
        ];

        try {
            $response = $this->paypalClient->execute($request);
            $links = $response->result->links;
            $approvalUrl = $links[1]->href;

            return redirect($approvalUrl);
        } catch (\Exception $e) {
            Log::error('PayPal Error: ' . $e->getMessage());
            return redirect()->route('checkout.show')->with('error', 'Something went wrong with PayPal.');
        }
    }

    // Handle successful payment
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->payment_status = 'paid';
        $order->save();

        CartItem::where('user_id', auth()->id())->delete();

        return view('checkout.success', ['order' => $order]);
    }

    // Handle cancelled payment
    public function cancel($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->payment_status = 'cancelled';
        $order->save();

        return redirect()->route('checkout.show')->with('error', 'Payment was cancelled.');
    }
}
