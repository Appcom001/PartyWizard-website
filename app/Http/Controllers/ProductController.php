<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Coupon;

class ProductController extends Controller
{
    // Display all products
    public function index()
    {
        $products = Product::all();
        
        if (request()->ajax()) {
            $products = $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'average_rating' => $product->average_rating, 
                    'photo' => $product->photo,
                    'revenues' => $product->revenues,
                    'sales' => $product->sales,
                    'discount' => $product->discount,
                    'price' => $product->price,
                    'stock' => $product->stock,
                ];
            });
    
            return response()->json(['products' => $products]);
        }
    
        return view('admin.products.index', compact('products'));
    }

    // Search products by title or ID
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        try {
            $products = Product::where('title', 'LIKE', "%{$query}%")
                                ->orWhere('id', $query)
                                ->get()
                                ->map(function($product) {
                                    return [
                                        'id' => $product->id,
                                        'title' => $product->title,
                                        'photo' => $product->photo,
                                        'revenues' => $product->revenues,
                                        'sales' => $product->sales,
                                        'discount' => $product->discount,
                                        'price' => $product->price,
                                        'stock' => $product->stock,
                                        'average_rating' => $product->average_rating
                                    ];
                                });
    
            return response()->json(['products' => $products]);
        } catch (\Exception $e) {
            \Log::error('Error fetching products: '.$e->getMessage());
            return response()->json(['error' => 'Unable to fetch products.'], 500);
        }
    }

    // Show product details
    public function show($id)
    {
        $product = Product::with('brand')->findOrFail($id);
    
        $similarProducts = Product::where('brand_id', $product->brand_id)
            ->where('id', '!=', $id)
            ->get();
    
        $discountedPrice = $this->calculateDiscountedPrice($product);
    
        $initialReviewCount = 2;
        $reviews = $this->getProductReviews($id, $initialReviewCount);
    
        return view('products.show', [
            'product' => $product,
            'similarProducts' => $similarProducts,
            'discountedPrice' => $discountedPrice,
            'initialReviewCount' => $initialReviewCount,
            'initialReviews' => $reviews['initialReviews'],
            'moreReviews' => $reviews['moreReviews']
        ]);
    }

    // Show add product form
    public function add()
    {
        $categories = Category::all();  
        $brands = Brand::all();  
        
        return view('admin.products.add', compact('categories', 'brands'));
    }

    // Calculate the discounted price of a product
    private function calculateDiscountedPrice(Product $product): float
    {
        if ($product->discount > 0) {
            $discountAmount = $product->price * ($product->discount / 100);
            return $product->price - $discountAmount;
        }
        return $product->price;
    }

    // Delete the old product image from storage
    private function deleteOldProductImage(Product $product): void
    {
        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }
    }

    // Retrieve product reviews
    private function getProductReviews(int $productId, int $initialCount): array
    {
        $reviews = ProductReview::where('product_id', $productId)
            ->with('user')
            ->latest()
            ->get();

        $reviewsCollection = collect($reviews);

        return [
            'initialReviews' => $reviewsCollection->take($initialCount),
            'moreReviews' => $reviewsCollection->slice($initialCount),
        ];
    }

    // Store a new product
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'summary' => 'required|string|max:255',
            'description' => 'required|string',
            'weight' => 'required|numeric',
            'material' => 'required|string',
            'color' => 'required|string|max:50',
            'category' => 'required|exists:categories,id',
            'brand' => 'required|exists:brands,id',
            'price' => 'required|numeric',
            'tax' => 'required|numeric',
            'discount' => 'required|numeric',
            'model' => 'required|string|max:100',
            'stock' => 'required|integer',
            'size' => 'required|string|max:50',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = new Product();
        $product->title = $request->input('name');
        $product->summary = $request->input('summary');
        $product->description = $request->input('description');
        $product->product_weight = $request->input('weight');
        $product->color = $request->input('color');
        $product->material = $request->input('material');
        $product->cat_id = $request->input('category');
        $product->brand_id = $request->input('brand');
        $product->price = $request->input('price');
        $product->vat = $request->input('tax');
        $product->discount = $request->input('discount');
        $product->model_number = $request->input('model');
        $product->stock = $request->input('stock');
        $product->size = $request->input('size');
    
        $file = $request->file('photo');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension(); 
        $file->storeAs('public/product_images', $filename);
        $product->photo = $filename; 
    
        $product->save();
    
        return redirect()->route('admin.products.index')->with('success', 'Product added successfully');
    }

    // Store a new promo code
    public function promostore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promo_code' => 'required|string|max:255',
            'discount' => 'required|numeric|min:0',
            'type' => 'required|in:percent,fixed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $coupons = new Coupon();
            $coupons->code = $request->input('promo_code');
            $coupons->value = $request->input('discount');
            $coupons->type = $request->input('type');
            $coupons->save();

            return redirect()->back()->with('success', 'Promo code generated successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to generate promo code: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate promo code. Please try again.');
        }
    }

    // Show edit form for a product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'summary' => 'required|string|max:255',
            'description' => 'required|string',
            'weight' => 'required|numeric',
            'material' => 'required|string',
            'color' => 'required|string|max:50',
            'category' => 'required|exists:categories,id',
            'brand' => 'required|exists:brands,id',
            'price' => 'required|numeric',
            'tax' => 'required|numeric',
            'discount' => 'required|numeric',
            'model' => 'required|string|max:100',
            'stock' => 'required|integer',
            'size' => 'required|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = Product::findOrFail($id);
        $product->title = $request->input('name');
        $product->summary = $request->input('summary');
        $product->description = $request->input('description');
        $product->product_weight = $request->input('weight');
        $product->color = $request->input('color');
        $product->material = $request->input('material');
        $product->cat_id = $request->input('category');
        $product->brand_id = $request->input('brand');
        $product->price = $request->input('price');
        $product->vat = $request->input('tax');
        $product->discount = $request->input('discount');
        $product->model_number = $request->input('model');
        $product->stock = $request->input('stock');
        $product->size = $request->input('size');
    
        if ($request->hasFile('photo')) {
            $this->deleteOldProductImage($product); // Delete old image
            $file = $request->file('photo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/product_images', $filename);
            $product->photo = $filename;
        }
    
        $product->save();
    
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->deleteOldProductImage($product); // Delete image
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
