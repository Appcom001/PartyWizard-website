@extends('admin.layouts.admin')
@section('content')
    <!-- Middle sec (left) -->
    <div class="pt-4 middle-sec-setting w-2/3">
        <form class="w-full pe-10" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col gap-4">
                <!-- Add product -->
                <div class="w-full bg-white rounded-lg p-6">
                    <p class="text-gray-900 font-semibold text-sm">Add product</p>

                    <div class="form-group mt-5">
                        <label for="product-name" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                        <input id="product-name" name="name"
                            class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                            placeholder="Product name">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group mt-5">
                        <label for="product-summary" class="block mb-2 text-sm font-medium text-gray-900">Summary</label>
                        <input id="product-summary" name="summary"
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
                            class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                            placeholder="Product Description"></textarea>
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
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to
                                        upload</span> or drag
                                    and drop</p>
                                <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input id="product-photo" name="photo" type="file" class="hidden"
                                accept=".jpg,.jpeg,.png,.gif" onchange="displayFileName()" />
                        </label>
                    </div>
                    <p id="file-name" class="text-gray-700 mt-2"></p>
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

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-lg bg-white">
                        <label for="product-weight" class="block mb-2 text-sm font-semibold text-gray-900">Product
                            Weight</label>
                        <input type="text" id="product-weight" name="weight"
                            class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                            placeholder="0">
                        @error('weight')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    <div class="p-4 rounded-lg bg-white">
                        <label for="product-color" class="block mb-2 text-sm font-semibold text-gray-900">Product
                            Color</label>
                        <input type="text" id="product-color" name="color"
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
                            <option selected disabled>Choose a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="p-4 rounded-lg bg-white">
                        <label for="product-brand" class="block mb-2 text-sm font-semibold text-gray-900">Product
                            Brand</label>
                        <select id="product-brand" name="brand"
                            class="bg-gray-50 border border-gray-200 text-sm rounded-lg focus:ring-gray-300 focus:border-gray-300 block w-full p-2.5">
                            <option selected disabled>Choose a Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                            @endforeach

                        </select>

                        @error('brand')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>




                </div>

            </div>
    </div>

    <!-- Right sec (right) -->
    <div class="pt-4 right-sec-setting w-1/3">
        <div class="flex flex-col gap-4">
            <!-- price and details -->
            <div class="p-4 rounded-lg bg-white">
                <label for="product-price" class="block mb-2 text-sm font-semibold text-gray-900">Price</label>
                <input type="text" id="product-price" name="price"
                    class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                    placeholder="$ 0.00 USD">
                @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="p-4 rounded-lg bg-white">
                <label for="product-weight" class="block mb-2 text-sm font-semibold text-gray-900">Product
                    Material</label>
                <input type="text" id="product-weight" name="material"
                    class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                    placeholder="Plastic">
                @error('material')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="p-4 rounded-lg bg-white">
                <label for="product-tax" class="block mb-2 text-sm font-semibold text-gray-900">Tax</label>
                <input type="text" id="product-tax" name="tax"
                    class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                    placeholder="Enter VAT">
                @error('tax')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="p-4 rounded-lg bg-white">
                <label for="product-discount" class="block mb-2 text-sm font-semibold text-gray-900">Discount</label>
                <input type="text" id="product-discount" name="discount"
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
                    class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200"
                    placeholder="83657">
                @error('model')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="p-4 rounded-lg bg-white">
                <label for="product-stock" class="block mb-2 text-sm font-semibold text-gray-900">Stock</label>
                <input type="text" id="product-stock" name="stock"
                    class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200" placeholder="0">
                @error('stock')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="p-4 rounded-lg bg-white">
                <label for="product-size" class="block mb-2 text-sm font-semibold text-gray-900">Product
                    Size</label>
                <input type="text" id="product-size" name="size"
                    class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border-2 border-gray-200" placeholder="0">
                @error('size')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

            </div>


        </div>

    </div>

    </div>
    <!-- end -->

    <!-- Save -->
    <div class="bg-white rounded-lg p-6 mt-3 ml-48">
        <div class="flex items-center justify-between w-full mt-5">
            <a href="" class="text-md font-medium text-gray-500">Unsaved product</a>
            <button type="submit" class=" px-10 py-2 bg-custom-orange text-white text-sm  rounded-lg">
                Save
            </button>

        </div>


    </div>
    </form>



    <form action="{{ route('promotions.store') }}" method="post">
        @csrf
        <div class="bg-white rounded-lg p-6 mt-3 flex justify-between items-center ml-48 mb-5">

            <!-- Discount Slider -->
            <div class="discount">
                <label for="price" class="block mb-2 text-sm font-semibold text-gray-900 mr-4">Discount
                    Percentage</label>
                <div class="flex items-center block">
                    <div id="percentageDisplay"
                        class="w-16 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-sm mr-4">
                        10%
                    </div>
                    <input type="range" id="percentageSlider" min="0" max="100" step="5"
                        value="10" name="discount" class="w-full cursor-pointer mt-1">
                </div>
            </div>

            <script>
                // slider range discount
                const slider = document.getElementById('percentageSlider');
                const display = document.getElementById('percentageDisplay');
                slider.addEventListener('input', function() {
                    const value = Math.round(this.value / 5) * 5;
                    display.textContent = value + '%';
                });
            </script>

            <!-- Promo Code Input and Generate Button -->
            <div class="flex items-center items-center ml-4">
                <div class="flex flex-col">
                    <label for="promo_code" class="block text-sm font-semibold text-gray-900 mb-2">Enter promo
                        code here</label>
                    <input type="text" id="promo_code" name="promo_code" placeholder="PromoCode"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm mb-0.5 focus:outline-none w-96">
                    @error('promo_code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col ml-4 mb-3.5">
                    <label for="product-category" class="block mb-2 text-sm font-semibold text-gray-900">Type</label>
                    <select id="product-category" name="type"
                        class="bg-gray-50 -mb-2 border border-gray-200 text-sm rounded-lg focus:ring-gray-300 focus:border-gray-300 block w-full p-2.5">
                        <option value="percent" selected>Percent</option>
                        <option value="fixed">Fixed</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="ml-4 px-10 py-2 bg-custom-orange text-white text-sm mt-6 rounded-lg">
                    Generate
                </button>
            </div>
        </div>
    </form>
@endsection
