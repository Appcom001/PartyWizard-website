@extends('admin.layouts.admin')
@section('content')
    <form class="w-full pe-10" action="{{ route('admin.products.update', $product->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        <div class="flex flex-col gap-4">
            <!-- Edit product -->
            <div class="w-full bg-white rounded-lg p-6">
                <p class="text-gray-900 font-semibold text-sm">Edit product</p>

                <div class="form-group mt-5">
                    <label for="product-name" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                    <input id="product-name" name="name" value="{{ old('name', $product->title) }}"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                        placeholder="Product name">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mt-5">
                    <label for="product-summary" class="block mb-2 text-sm font-medium text-gray-900">Summary</label>
                    <input id="product-summary" name="summary" value="{{ old('summary', $product->summary) }}"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                        placeholder="Product summary">
                    @error('summary')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mt-5">
                    <label for="product-description"
                        class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                    <textarea id="product-description" name="description" rows="4"
                        class="block p-2.5 w-full h-64 text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                        placeholder="Product Description">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- photo -->
            <div class="w-full bg-white rounded-lg p-6">
                <p class="text-gray-900 font-semibold text-sm">Photo</p>
                <div class="flex items-center justify-center w-full mt-5">
                    <label for="product-photo"
                        class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-100">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to
                                    upload</span> or drag
                                and drop</p>
                            <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="product-photo" name="photo" type="file" class="hidden" accept=".jpg,.jpeg,.png,.gif"
                            onchange="displayFileName()" />
                    </label>
                </div>
                <p id="file-name" class="text-gray-700 mt-2">
                    @if ($product->photo)
                        {{ basename($product->photo) }}
                    @endif
                </p>
                @error('photo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <script>
                function displayFileName() {
                    const input = document.getElementById('product-photo');
                    const fileNameElement = document.getElementById('file-name');
                    const file = input.files[0];
                    if (file) {
                        fileNameElement.textContent = file.name;
                    } else {
                        fileNameElement.textContent = '';
                    }
                }
            </script>

            <div class="grid grid-cols-3 gap-4">
                <div class="p-4 rounded-lg bg-white">
                    <label for="product-weight" class="block mb-2 text-sm font-semibold text-gray-900">Product
                        Weight</label>
                    <input type="text" id="product-weight" name="weight"
                        value="{{ old('weight', $product->product_weight) }}"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                        placeholder="0">
                    @error('weight')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 rounded-lg bg-white">
                    <label for="product-color" class="block mb-2 text-sm font-semibold text-gray-900">Product Color</label>
                    <input type="text" id="product-color" name="color" value="{{ old('color', $product->color) }}"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                        placeholder="Black, White, Blue">
                    @error('color')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 rounded-lg bg-white">
                    <label for="product-category" class="block mb-2 text-sm font-semibold text-gray-900">Product
                        Category</label>
                    <select id="product-category" name="category"
                        class="bg-gray-50 border border-gray-200 text-sm rounded-lg focus:ring-gray-300 focus:border-gray-300 block w-full p-2.5">
                        <option disabled>Choose a Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                {{ $category->title }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 rounded-lg bg-white">
                    <label for="product-brand" class="block mb-2 text-sm font-semibold text-gray-900">Product Brand</label>
                    <select id="product-brand" name="brand"
                        class="bg-gray-50 border border-gray-200 text-sm rounded-lg focus:ring-gray-300 focus:border-gray-300 block w-full p-2.5">
                        <option disabled>Choose a Brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                {{ $brand->title }}</option>
                        @endforeach
                    </select>
                    @error('brand')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- price and details -->
                <div class="p-4 rounded-lg bg-white">
                    <label for="product-price" class="block mb-2 text-sm font-semibold text-gray-900">Price</label>
                    <input type="text" id="product-price" name="price" value="{{ old('price', $product->price) }}"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                        placeholder="$ 0.00 USD">
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 rounded-lg bg-white">
                    <label for="product-material" class="block mb-2 text-sm font-semibold text-gray-900">Product
                        Material</label>
                    <input type="text" id="product-material" name="material"
                        value="{{ old('material', $product->material) }}"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                        placeholder="Plastic">
                    @error('material')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 rounded-lg bg-white">
                    <label for="product-tax" class="block mb-2 text-sm font-semibold text-gray-900">Tax</label>
                    <input type="text" id="product-tax" name="tax" value="{{ old('tax', $product->vat) }}"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                        placeholder="Enter VAT">
                    @error('tax')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 rounded-lg bg-white">
                    <label for="product-discount" class="block mb-2 text-sm font-semibold text-gray-900">Discount</label>
                    <input type="text" id="product-discount" name="discount"
                        value="{{ old('discount', $product->discount) }}"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                        placeholder="Enter Discount">
                    @error('discount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 rounded-lg bg-white">
                    <label for="product-model" class="block mb-2 text-sm font-semibold text-gray-900">Model
                        Number</label>
                    <input type="text" id="product-model" name="model"
                        value="{{ old('model', $product->model_number) }}"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                        placeholder="83657">
                    @error('model')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 rounded-lg bg-white">
                    <label for="product-stock" class="block mb-2 text-sm font-semibold text-gray-900">Stock</label>
                    <input type="text" id="product-stock" name="stock" value="{{ old('stock', $product->stock) }}"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                        placeholder="0">
                    @error('stock')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 rounded-lg bg-white">
                    <label for="product-size" class="block mb-2 text-sm font-semibold text-gray-900">Product
                        Size</label>
                    <input type="text" id="product-size" name="size" value="{{ old('size', $product->size) }}"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                        placeholder="0">
                    @error('size')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <!-- Save -->
        <div class="bg-white rounded-lg p-6 mt-3 ml-48 mr-16">
            <div class="flex items-center justify-between w-full mt-5">
                <a href="" class="text-md font-medium text-gray-500">Unsaved product</a>
                <button type="submit" class=" px-10 py-2 bg-custom-orange text-white text-sm  rounded-lg">
                    Save
                </button>

            </div>


        </div>
    </form>
@endsection
