@extends('admin.layouts.admin')
@section('content')

    <!-- middle sec -->
    <div class="pt-4  middle-sec-setting">
        <!-- boxes -->
        <div class="grid grid-cols-4 gap-4 mb-4">
            <!-- Total -->
            <div class="flex flex-col items-start justify-start gap-4 h-34 rounded-lg bg-white p-3 shadow-md">
                <img src="{{ asset('assets/images/total.svg') }}" alt="Total Sales" class="w-8" />
                <p class="text-gray-500 text-sm">Total sales</p>
                <p class="text-gray-800 font-bold text-md">${{ number_format($totalSales, 2) }}</p>
            </div>

            <!-- Returns -->
            <div class="flex flex-col items-start justify-start gap-4 h-34 rounded-lg bg-white p-3 shadow-md">
                <img src="{{ asset('assets/images/returns.svg') }}" alt="Returns" class="w-8" />
                <p class="text-gray-500 text-sm">Returns</p>
                <p class="text-gray-800 font-bold text-md">{{ $totalReturns }}</p>
            </div>

            <!-- Sales Income -->
            <div class="flex flex-col items-start justify-start gap-4 h-34 rounded-lg bg-white p-3 shadow-md">
                <img src="{{ asset('assets/images/sales.svg') }}" alt="Sales Income" class="w-8" />
                <p class="text-gray-500 text-sm">Sales income</p>
                <p class="text-gray-800 font-bold text-md">${{ number_format($totalSalesIncome, 2) }}</p>
            </div>

            <!-- Rating -->
            <div class="flex flex-col items-start justify-start gap-4 h-34 rounded-lg bg-white p-3 shadow-md">
                <img src="{{ asset('assets/images/rating.svg') }}" alt="Rating" class="w-8" />
                <p class="text-gray-500 text-sm">Rating</p>
                <div class="text-md">
                    <div class="flex items-center mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 ms-1 {{ $i <= $averageRating ? 'text-yellow-300' : 'text-gray-300' }}"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 22 20">
                                <path
                                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-500 text-sm">Average Rating: {{ number_format($averageRating, 1) }} / 5</p>
                </div>
            </div>
        </div>


        <!-- table -->
        <div class="bg-white rounded-lg p-6">
            <!-- filter -->
            <div class="flex justify-between mb-3 items-center">
                <div class="flex items-center gap-2">
                    <span class="text-lg font-semibold">Latest Orders</span>
                </div>
                <div class="flex items-center space-x-3">

                    <!-- Time Range Filter Form -->
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                        <select name="time_range" id="time_range"
                            class="bg-gray-50 border border-gray-200 text-gray-600 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-32 p-2.5">
                            <option value="today" {{ request('time_range') === 'today' ? 'selected' : '' }}>Today</option>
                            <option value="last-7-days" {{ request('time_range') === 'last-7-days' ? 'selected' : '' }}>
                                Last 7 Days</option>
                            <option value="last-month" {{ request('time_range') === 'last-month' ? 'selected' : '' }}>Last
                                Month</option>
                            <option value="custom" {{ request('time_range') === 'custom' ? 'selected' : '' }}>Custom Range
                            </option>
                        </select>
                        <button type="submit" name="filter_by_time_range" value="1"
                            class="bg-custom-orange text-white p-2 text-sm rounded-lg flex items-center">
                            Search
                        </button>
                    </form>

                </div>
            </div>

            <div class="overflow-x-auto">
                @if ($orders->isEmpty())
                    <p class="text-center text-gray-500 py-4">No orders found.</p>
                @else
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase border-b dark:border-gray-700">
                            <tr>
                                <th scope="col" class="py-6 px-4 font-bold">#Order</th>
                                <th scope="col" class="py-6 px-4 font-bold">Customer</th>
                                <th scope="col" class="py-6 px-4 font-bold">Payment</th>
                                <th scope="col" class="py-6 px-4 font-bold">Payment Status</th>
                                <th scope="col" class="py-6 px-4 font-bold">Status</th>
                                <th scope="col" class="py-6 px-4 font-bold">Amount</th>
                                <th scope="col" class="py-6 px-4 font-bold">City</th>
                                <th scope="col" class="py-6 px-4 font-bold">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="py-4 px-4">{{ $order->order_number }}</td>
                                    <td class="py-4 px-4">
                                        <div class="font-medium">{{ $order->first_name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->email ?? 'N/A' }}</div>
                                    </td>
                                    <td class="py-4 px-4">{{ $order->payment_method ?? 'N/A' }}</td>
                                    <td class="py-4 px-4">{{ $order->payment_status ?? 'N/A' }}</td>
                                    <td class="py-4 px-4">{{ $order->status ?? 'N/A' }}</td>
                                    <td class="py-4 px-4">{{ $order->total_amount ?? 'N/A' }}</td>
                                    <td class="py-4 px-4 font-medium text-gray-900 whitespace-nowrap">
                                        <p class="text-xs">{{ $order->city ?? 'N/A' }}</p>
                                    </td>
                                    <td class="py-4 px-4">{{ $order->address1 ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>

    <!-- right sec -->
    <div class="ml-10 pt-4 right-sec-setting">
        <div class="p-4 rounded-lg h-auto bg-white">
            <!-- icons -->
            <div class="flex items-end justify-end mb-6">
                <div class="flex items-center space-x-4">
                    <!-- Notification Icon -->
                    <a
                        class="rounded-md hover:bg-gray-100 w-10 h-10 border-2 border-gray-300 flex items-center justify-center">
                        <i class="far fa-bell text-gray-400"></i>
                    </a>

                    <!-- User Icon -->
                    <a href="{{ route('admin.settings') }}"
                        class="rounded-md hover:bg-gray-100 w-10 h-10 border-2 border-gray-300 flex items-center justify-center">
                        <i class="far fa-user text-gray-400"></i>
                    </a>
                </div>
            </div>

            <!-- User welcome message -->
            <div class="flex items-center mb-6">
                <!-- User Image -->
                <div class="rounded-full w-14 h-14 border-2 border-gray-300 flex items-center justify-center">
                    <img class="w-6 h-6 rounded-full" src="{{ asset('assets/images/Icon feather-user(1).svg') }}"
                        alt="User Profile Picture">
                </div>

                <!-- Welcome Text -->
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">
                        Welcome back!
                    </p>
                    <p class="text-md font-semibold text-gray-800">
                        {{ Auth::guard('admin')->user()->first_name ?? 'Admin' }}
                    </p>
                </div>
            </div>

            <!-- reviews  -->
            <span>Reviews</span>
            <div class="flex flex-col items-start ">

                @if (session('reviews'))
                    @foreach (session('reviews') as $review)
                        <div class="gap-3 py-4 sm:flex sm:items-start mt-2">
                            <div class="shrink-0 space-y-2 w-full">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="rounded-full w-9 h-9 border-2 border-gray-300 flex items-center justify-center">
                                        <img class="w-4 h-4" src="{{ asset('assets/images/Icon feather-user(1).svg') }}"
                                            alt="">
                                    </div>
                                    <div class="flex flex-col items-start gap-1">
                                        <p class="text-xs text-gray-500 dark:text-white">
                                            {{ $review->user->name ?? 'Unknown' }} <!-- تأكد من وجود بيانات المستخدم -->
                                        </p>
                                        <div class="flex items-center gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="h-3 w-3 {{ $i <= $review->rate ? 'text-yellow-300' : 'text-gray-300' }}"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex-1 space-y-4 sm:mt-0 w-full">
                                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        {{ $review->review }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No reviews available.</p>
                @endif




            </div>
        </div>
    </div>

@endsection
