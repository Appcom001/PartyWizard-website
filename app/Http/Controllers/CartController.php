<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    // Display user's cart items
    public function viewCart()
    {
        $user_id = auth()->id();
        $cartItems = CartItem::where('user_id', $user_id)->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        if ($cartItems->isEmpty()) {
            session()->forget('discount');
            $discount = 0;
        } else {
            $discount = session('discount', 0);
        }

        $total = $subtotal - $discount;
        session(['cartItemCount' => $cartItems->count()]);

        return view('cart.view', compact('cartItems', 'subtotal', 'discount', 'total'));
    }

    // Add product to cart
    public function addToCart(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'You need to be logged in to add items to the cart.');
        }

        $product = Product::findOrFail($request->input('product_id'));
        $user_id = auth()->id();
        $quantity = $request->input('quantity', 1);

        $cartItem = CartItem::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => $user_id],
            [
                'quantity' => \DB::raw('quantity + ' . $quantity),
                'price' => $product->price,
                'amount' => \DB::raw('price * (quantity + ' . $quantity . ')')
                ]
            );
            
            $this->updateCartItemCount($user_id);
            
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        
        // Update cart item quantity
        public function update(Request $request, $id)
        {
            $cartItem = CartItem::findOrFail($id);
            $action = $request->input('action');
            $quantity = $request->input('quantity');
            
            if ($action === 'increment') {
                $cartItem->quantity++;
            } elseif ($action === 'decrement' && $quantity > 1) {
                $cartItem->quantity--;
            }
            
            $cartItem->amount = ($cartItem->price * $cartItem->quantity);
            $cartItem->save();
            
            return redirect()->back()->with('success', 'Cart item updated successfully!');
        }
        
        // Update cart item count in session
        private function updateCartItemCount($user_id)
        {
            $count = CartItem::where('user_id', $user_id)->count();
            session(['cartItemCount' => $count]);
        }
        
        // Remove item from cart
        public function delete($id)
        {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        $this->updateCartItemCount(auth()->id());

        if (CartItem::where('user_id', auth()->id())->count() === 0) {
            session()->forget('discount');
        }

        return redirect()->back()->with('success', 'Item removed from cart successfully!');
    }

    // Clear all items from cart
    public function clear()
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'You need to be logged in to clear the cart.');
        }

        CartItem::where('user_id', auth()->id())->delete();
        session()->forget('discount');
        session(['cartItemCount' => 0]);

        return redirect()->back()->with('success', 'All items have been removed from the cart.');
    }

}
