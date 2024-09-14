@extends('admin.layouts.admin')

@section('content')
    <div class="pt-4 w-full">
        <!-- Search and Icons -->
        <div class="flex w-full items-center gap-4 bg-white p-4 rounded-lg">
            <!-- Search Bar -->
            <div class="relative flex items-center gap-3 w-full">
                <input type="text" id="searchQuery"
                    class="pl-10 border border-gray-300 rounded-lg py-2 w-full focus:outline-none focus:border-gray-200 transition-all duration-300"
                    placeholder="Search by Product Name or Product ID " />
                <button id="searchButton"
                    class="absolute left-3 text-gray-500 hover:text-gray-700 transition-all duration-300">
                    <i class="fas fa-search text-gray-400 text-sm"></i>
                </button>
            </div>
            <!-- Icons -->
            <div class="flex items-center space-x-4">
                <!-- Notification Icon -->
                <a
                    class="rounded-lg hover:bg-gray-100 w-10 h-10 border-2 border-gray-300 flex items-center justify-center transition-all duration-300">
                    <i class="far fa-bell text-gray-600 text-md"></i>
                </a>
                <!-- User Icon -->
                <a
                    class="rounded-lg hover:bg-gray-100 w-10 h-10 border-2 border-gray-300 flex items-center justify-center transition-all duration-300">
                    <i class="far fa-user text-gray-600 text-md"></i>
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg p-6 mt-5">
            <!-- Header with buttons -->
            <div class="flex justify-between mb-3 items-center">
                <span class="text-lg font-semibold">Manage Products</span>
                <!-- New Product button with icon -->
                <div class="relative">
                    <a href="{{ route('admin.products.add') }}"
                        class="bg-custom-orange text-white text-sm rounded-lg px-4 py-2 flex items-center gap-2 hover:bg-blue-600 transition-all duration-300">
                        <i class="fas fa-plus"></i>
                        <span>New Product</span>
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase border-b dark:border-gray-700">
                        <tr>
                            <th scope="col" class="py-6 px-4 font-bold">#</th>
                            <th scope="col" class="py-6 px-4 font-bold">Product</th>
                            <th scope="col" class="py-6 px-4 font-bold">Image</th>
                            <th scope="col" class="py-6 px-4 font-bold">Revenues</th>
                            <th scope="col" class="py-6 px-4 font-bold">Sales</th>
                            <th scope="col" class="py-6 px-4 font-bold">Offer</th>
                            <th scope="col" class="py-6 px-4 font-bold">Price</th>
                            <th scope="col" class="py-6 px-4 font-bold">Rating</th>
                            <th scope="col" class="py-6 px-4 font-bold">Stock</th>
                            <th scope="col" class="py-6 px-4 font-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        @foreach ($products as $product)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-4 font-semibold">#{{ $product->id }}</td>
                                <td class="py-4 px-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $product->title }}</td>
                                <td class="py-4 px-4">
                                    <img class="w-9 h-9 rounded-lg"
                                        src="{{ asset('storage/product_images/' . $product->photo) }}"
                                        alt="Product Image" />
                                </td>
                                <td class="py-4 px-4">
                                    <span class="font-semibold text-gray-600 text-md">--</span>
                                    <!-- Placeholder for Revenues -->
                                </td>
                                <td class="py-4 px-4">
                                    <span class="font-semibold text-gray-600 text-md">--</span>
                                    <!-- Placeholder for Sales -->
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="bg-green-50 text-green-600 text-md font-semibold px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                        {{ $product->discount }}%
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="font-semibold text-gray-600 text-md">${{ $product->price }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="font-semibold text-gray-600 text-md">{{ $product->average_rating }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="font-semibold text-gray-600 text-md">{{ $product->stock }}</span>
                                </td>
                                <td class="py-4 px-4 flex gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="text-white bg-yellow-300 rounded-md p-2 px-3 hover:bg-yellow-700 flex items-center">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button
                                            class="text-white bg-red-500 rounded-md p-2 px-3 hover:bg-red-700 flex items-center">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function fetchProducts(query = '') {
                $.ajax({
                    url: query ? "{{ route('admin.products.search') }}" :
                        "{{ route('admin.products.index') }}",
                    type: 'GET',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        updateProductTable(response.products);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error);
                    }
                });
            }

            function updateProductTable(products) {
                let tbody = $('#productTableBody');
                tbody.empty();

                if (products.length > 0) {
                    $.each(products, function(index, product) {
                        tbody.append(`
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-4 font-semibold">#${product.id}</td>
                                        <td class="py-4 px-4 font-medium text-gray-900 whitespace-nowrap">${product.title}</td>
                                        <td class="py-4 px-4">
                                            <img class="w-9 h-9 rounded-lg" src="/storage/product_images/${product.photo}" alt="Product Image" />
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="font-semibold text-gray-600 text-md">${product.revenues || '--'}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="font-semibold text-gray-600 text-md">${product.sales || '--'}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="bg-green-50 text-green-600 text-md font-semibold px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                ${product.discount}%
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="font-semibold text-gray-600 text-md">$ ${product.price}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="font-semibold text-gray-600 text-md">${product.average_rating}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="font-semibold text-gray-600 text-md">${product.stock}</span>
                                        </td>
                                        <td class="py-4 px-4 flex gap-2">
                                            <a href="/admin/products/edit/${product.id}" class="text-white bg-yellow-300 rounded-md p-2 px-3 hover:bg-yellow-700">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="/admin/products/destroy/${product.id}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-white bg-red-500 rounded-md p-2 px-3 hover:bg-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                `);
                    });
                } else {
                    tbody.append('<tr><td colspan="10" class="text-center py-4">No results found</td></tr>');
                }
            }

            $('#searchQuery').on('input', function() {
                let query = $(this).val();
                fetchProducts(query);
            });

            fetchProducts();
        });
    </script>
@endsection
