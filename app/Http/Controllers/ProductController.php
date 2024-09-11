<?php

namespace App\Http\Controllers;
use App\Models\ProductReview;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * عرض جميع المنتجات.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * عرض تفاصيل منتج محدد.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $product = Product::with('brand')->findOrFail($id);
        $similarProducts = Product::where('brand_id', $product->brand_id)
            ->where('id', '!=', $id)
            ->take(4)
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
    
    public function add()
    {
        // Assuming you have Category and Brand models
        $categories = Category::all();  // Fetch all categories
        $brands = Brand::all();  // Fetch all brands
        
        return view('admin.products.add', compact('categories', 'brands'));
    }
    

        /**
     * تحديث منتج موجود.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validatedData = $this->validateProductData($request, $id);

        if ($request->hasFile('photo')) {
            $this->deleteOldProductImage($product);
            $validatedData['photo'] = $this->storeProductImage($request->file('photo'));
        }

        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'تم تحديث المنتج بنجاح');
    }

    
    /**
     * حذف منتج.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->deleteOldProductImage($product);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'تم حذف المنتج بنجاح');
    }


    

    /**
     * حساب السعر بعد الخصم للمنتج.
     *
     * @param Product $product
     * @return float
     */
    private function calculateDiscountedPrice(Product $product): float
    {
        if ($product->discount > 0) {
            $discountAmount = $product->price * ($product->discount / 100);
            $discountedPrice = $product->price - $discountAmount;
            return $discountedPrice;
        } else {
            return $product->price;
        }
    }

        /**
     * حذف صورة المنتج القديمة.
     *
     * @param Product $product
     * @return void
     */
    private function deleteOldProductImage(Product $product): void
    {
        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }
    }



    
    /**
     * الحصول على تقييمات المنتج.
     *
     * @param int $productId
     * @param int $initialCount
     * @return array
     */
    private function getProductReviews(int $productId, int $initialCount): array
    {
        $reviews = ProductReview::where('product_id', $productId)
            ->with('user')
            ->latest()
            ->get();

        // استخدام Collection methods
        $reviewsCollection = collect($reviews);

        return [
            'initialReviews' => $reviewsCollection->take($initialCount),
            'moreReviews' => $reviewsCollection->slice($initialCount),
        ];
    }








    /**
     * تخزين منتج جديد.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateProductData($request);
    
        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $this->storeProductImage($request->file('photo'));
        }
    
        try {
            Product::create($validatedData);
            return redirect()->route('products.index')->with('success', 'تم إنشاء المنتج بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'فشل في إنشاء المنتج: ' . $e->getMessage());
        }
    }
    

    /**
     * التحقق من صحة بيانات المنتج.
     *
     * @param Request $request
     * @param int|null $id
     * @return array
     */
    private function validateProductData(Request $request, ?int $id = null): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'summary' => 'required|string|max:255',
            'description' => 'required|string',
            'weight' => 'nullable|numeric',
            'color' => 'nullable|string',
            'category' => 'required|exists:categories,id',
            'brand' => 'required|exists:brands,id',
            'price' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'model' => 'nullable|string|max:255',
            'stock' => 'required|integer',
            'size' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    
        return $request->validate($rules);
    }
    

    /**
     * تخزين صورة المنتج.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    private function storeProductImage($file): string
    {
        return $file->store('product_images', 'public');
    }


}