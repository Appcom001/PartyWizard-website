<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party Wizard - analytics</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

    <script>
        let originalContent;

        function checkScreenWidth() {
            if (window.innerWidth < 900) {
                if (!originalContent) {
                    originalContent = document.body.innerHTML;
                }
                document.body.innerHTML = '<h1>You need to use a device with a screen larger than 900px, like an iPad or a laptop.</h1>';
            } else if (originalContent) {
                document.body.innerHTML = originalContent;
            }
        }

        window.addEventListener('resize', checkScreenWidth);
        window.addEventListener('load', checkScreenWidth);

        // Check immediately when the script runs
        checkScreenWidth();
    </script>
    
    <!-- === Favicon === -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logo_out_text.svg"') }}">
    <!-- === End Favicon === -->

    <!-- === Css === -->
    <link rel="stylesheet" href="{{ asset('assets/css/custoum.css') }}">
    <!-- === End css === -->

    <!-- === Tailwind CSS === -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- === End Tailwind CSS === -->

    <!-- === Flowbite === -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <!-- === End Flowbite === -->

    <!-- === Fontawesome === -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- === End Fontawesome === -->

    <!-- === Google Fonts Inter === -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- === End Google Fonts Inter === -->

    <style>
        #salesChart {
            height: 300px !important;
            width: 100% !important;
        }
    </style>

</head>

<body style="background-color: rgb(237, 237, 237) !important;">

    <!-- main content -->
    <div class="mx-auto max-w-screen-2xl sm:pr-6 lg:pr-8">

        <aside id="logo-sidebar"
            class="fixed top-0 left-0 z-40 w-44 h-screen transition-transform -translate-x-full sm:translate-x-0"
            aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center ps-2.5 mb-5">
                    <img src="{{ asset('assets/images/logo_out_text.svg') }}" class="me-3 h-12" alt="Logo" />
                </a>
                <ul class="space-y-7 font-medium mt-10">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center p-2 text-gray-400 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-4 h-4 text-gray-400 transition duration-75 " aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                <path
                                    d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                            </svg>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('analytics') }}"
                            class="flex items-center text-custom-orange p-2 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <i class="fas fa-chart-pie w-5 h-5 text-custom-orange  "></i>
                            <span class="flex-1 ms-3 whitespace-nowrap text-custom-orange">Analytics</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.products.index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <i class="fas fa-cube w-5 h-5  text-gray-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap text-gray-400">Products</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.settings') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <i class="fas fa-cog w-5 h-5  text-gray-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap text-gray-400">Settings</span>
                        </a>
                    </li>

                </ul>
            </div>
        </aside>

        <!-- content  -->
        <div class="pt-4 ml-48">

            <!-- Boxes -->
            <div class="grid grid-cols-3 gap-4 mb-4">
                <!-- Total Sales -->
                <div class="flex flex-col items-start justify-between gap-4 h-34 rounded-lg bg-white p-4">
                    <div class="flex items-center gap-4">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22.1714 8.14006C22.1714 9.82006 21.5314 10.4201 20.6914 10.6201C20.4114 10.6801 20.1214 10.7001 19.8114 10.7001H4.53139C4.23139 10.7001 3.92139 10.6901 3.63139 10.6201C3.32139 10.5501 3.03139 10.4201 2.79139 10.1701C2.37139 9.75006 2.17139 9.11006 2.17139 8.14006C2.17139 5.58006 4.04139 5.58006 4.94139 5.58006H5.34139L8.71139 2.20006C8.99139 1.93006 9.43139 1.93006 9.70139 2.20006C9.97139 2.48006 9.97139 2.92006 9.70139 3.19006L7.31139 5.58006H17.0314L14.6414 3.19006C14.3714 2.91006 14.3714 2.47006 14.6414 2.20006C14.9214 1.93006 15.3614 1.93006 15.6314 2.20006L19.0114 5.58006H19.4114C20.3014 5.58006 22.1714 5.58006 22.1714 8.14006Z"
                                fill="#F25510" />
                            <path
                                d="M20.2014 13.19L19.1914 18.42C18.8314 20.31 18.2314 22 14.8614 22H9.25142C5.92142 22 5.17142 20.02 4.89142 18.3L4.05142 13.16C3.95142 12.55 4.42142 12 5.04142 12H19.2214C19.8514 12 20.3214 12.57 20.2014 13.19ZM10.7814 15.15C10.7814 14.77 10.4714 14.45 10.0914 14.45C9.70142 14.45 9.39142 14.77 9.39142 15.15V18.45C9.39142 18.84 9.70142 19.15 10.0914 19.15C10.4714 19.15 10.7814 18.84 10.7814 18.45V15.15ZM15.0614 15.15C15.0614 14.77 14.7514 14.45 14.3614 14.45C13.9814 14.45 13.6614 14.77 13.6614 15.15V18.45C13.6614 18.84 13.9814 19.15 14.3614 19.15C14.7514 19.15 15.0614 18.84 15.0614 18.45V15.15Z"
                                fill="#F25510" />
                        </svg>

                        <p class="text-gray-500 text-md">Total Sales</p>
                    </div>
                    <p class="text-gray-800 font-bold text-xl">${{ number_format($totalSales, 2) }}</p>
                    <div class="status-new">
                        <div class="flex items-center gap-2 mb-2">
                            <p class="text-green-500 font-semibold text-sm">
                                <i class="fas fa-arrow-up"></i>
                                <span class="ms-2">+12.34%</span>
                            </p>
                            <p class="text-gray-400 text-xs">On this week</p>
                        </div>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="flex flex-col items-start justify-between gap-4 h-34 rounded-lg bg-white p-4">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('assets/images/note.svg') }}" alt="image" class="w-7">
                        <p class="text-gray-500 text-md">Total Orders</p>
                    </div>
                    <p class="text-gray-800 font-bold text-xl">{{ $totalOrders }}</p>
                    <div class="status-new">
                        <div class="flex items-center gap-2 mb-2">
                            <p class="text-red-500 font-semibold text-sm">
                                <i class="fas fa-arrow-down"></i>
                                <span class="ms-2">+6.34%</span>
                            </p>
                            <p class="text-gray-400 text-xs">On this week</p>
                        </div>
                    </div>
                </div>

                <!-- Refunded Amount -->
                <div class="flex flex-col items-start justify-between gap-4 h-34 rounded-lg bg-white p-4">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('assets/images/refresh-square-2.svg') }}" alt="image" class="w-7">
                        <p class="text-gray-500 text-md">Refunded</p>
                    </div>
                    <p class="text-gray-800 font-bold text-xl">${{ number_format($refundedAmount, 2) }}</p>
                    <div class="status-new">
                        <div class="flex items-center gap-2 mb-2">
                            <p class="text-yellow-400 font-semibold text-sm">no change</p>
                        </div>
                    </div>
                </div>

            </div>


            <!-- Charts -->
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Sales Overview Chart -->
                <div class="p-5 h-68 w-3/4 chart-container bg-white rounded-lg">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold mb-4">Sales Overview</h2>
                        <select class="bg-gray-50 border border-gray-200 text-gray-600 text-xs rounded-lg block w-32 ">
                            <option value="today">Today</option>
                            <option value="last-7-days">Last 7 Days</option>
                            <option value="last-month">Last Month</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <canvas id="salesChart" class="w-full h-80"></canvas>
                </div>

                <!-- Sales Distribution Chart -->
                <div class="p-5 h-68 w-1/4 chart-container bg-white rounded-lg">
                    <h2 class="text-sm font-semibold mb-4">Sales Distribution</h2>
                    <canvas id="pieChart" class="w-full h-48"></canvas>
                </div>
            </div>
            <!-- Charts Scripts -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Sales Overview Chart
                var ctx = document.getElementById('salesChart').getContext('2d');
                var salesChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        datasets: [{
                            label: 'Sales',
                            data: [12, 19, 3, 5, 2, 3, 7],
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Sales Distribution Chart
                var ctx2 = document.getElementById('pieChart').getContext('2d');
                var pieChart = new Chart(ctx2, {
                    type: 'pie',
                    data: {
                        labels: ['Product A', 'Product B', 'Product C', 'Product D'],
                        datasets: [{
                            label: 'Sales Distribution',
                            data: [10, 20, 30, 40],
                            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#E7E9ED']
                        }]
                    }
                });
            </script>
            <!-- Top Products Table -->
            <div class="bg-white rounded-lg p-6 mt-5">
                <div class="flex justify-between mb-3 items-center">
                    <span class="text-lg font-semibold">Top Products</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase border-b dark:border-gray-700">
                            <tr>
                                <th scope="col" class="py-6 px-4 font-bold text-gray-500">#</th>
                                <th scope="col" class="py-6 px-4 font-bold text-gray-500">Product Name</th>
                                <th scope="col" class="py-6 px-4 font-bold text-gray-500">Price</th>
                                <th scope="col" class="py-6 px-4 font-bold text-gray-500">Stock</th>
                                <th scope="col" class="py-6 px-4 font-bold text-gray-500">Color</th>
                                <th scope="col" class="py-6 px-4 font-bold text-gray-500">Model Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topProducts as $product)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="py-4 px-4">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-4 font-medium text-gray-900 whitespace-nowrap">
                                        <p class="text-xs">{{ $product->title }}</p>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span
                                            class="font-bold text-gray-400 text-xs">${{ number_format($product->price, 2) }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="font-bold text-gray-400 text-xs">{{ $product->stock }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="font-bold text-gray-400 text-xs">{{ $product->color }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span
                                            class="font-bold text-gray-400 text-xs">#{{ $product->model_number }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>





        </div>

    </div>
    <!-- end main content -->

    <!-- scripts assets -->

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

    <!-- === End jQuery === -->

    <!-- === Flowbite JS === -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

    <!-- === End Flowbite JS === -->



</body>

</html>
