<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party Wizard - CPanel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- === Favicon === -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logo_out_text.svg') }}">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        checkScreenWidth();
    </script>

</head>

<body style="background-color: rgb(237, 237, 237) !important;">

    <!-- main content -->
    <div class="mx-auto max-w-screen-2xl	">

        <aside id="logo-sidebar"
            class="fixed top-0 left-0 z-40 w-44 h-screen transition-transform -translate-x-full sm:translate-x-0"
            aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                <a href="{{ asset('assets/images/logo_out_text.svg') }}" class="flex justify-center items-center ps-2.5 mb-5">
                    <img src="{{ asset('assets/images/logo_out_text.svg') }}" class="me-3 h-16" alt="Logo" />
                </a>
                <ul class="space-y-7 font-medium mt-10">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center p-2 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 dark:bg-gray-700 text-custom-orange' : 'text-gray-900' }}">
                            <svg class="flex-shrink-0 w-4 h-4 transition duration-75 {{ request()->routeIs('admin.dashboard') ? 'text-custom-orange' : 'text-gray-400' }}"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 18 18">
                                <path
                                    d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                            </svg>
                            <span class="ms-3">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('analytics') }}"
                            class="flex items-center p-2 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.analytics') ? 'bg-gray-100 dark:bg-gray-700 text-custom-orange' : 'text-gray-900' }}">
                            <i
                                class="fas fa-chart-pie w-5 h-5 {{ request()->routeIs('admin.analytics') ? 'text-custom-orange' : 'text-gray-400' }}"></i>
                            <span
                                class="flex-1 ms-3 whitespace-nowrap {{ request()->routeIs('admin.analytics') ? 'text-custom-orange' : 'text-gray-400' }}">Analytics</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.products.index') }}"
                            class="flex items-center p-2 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.products.index') ? 'bg-gray-100 dark:bg-gray-700 text-custom-orange' : 'text-gray-900' }}">
                            <i
                                class="fas fa-cube w-5 h-5 {{ request()->routeIs('admin.products.index') ? 'text-custom-orange' : 'text-gray-400' }}"></i>
                            <span
                                class="flex-1 ms-3 whitespace-nowrap {{ request()->routeIs('admin.products.index') ? 'text-custom-orange' : 'text-gray-400' }}">Products</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.settings') }}"
                            class="flex items-center p-2 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('admin.settings') ? 'bg-gray-100 dark:bg-gray-700 text-custom-orange' : 'text-gray-900' }}">
                            <i
                                class="fas fa-cog w-5 h-5 {{ request()->routeIs('admin.settings') ? 'text-custom-orange' : 'text-gray-400' }}"></i>
                            <span
                                class="flex-1 ms-3 whitespace-nowrap {{ request()->routeIs('admin.settings') ? 'text-custom-orange' : 'text-gray-400' }}">Settings</span>
                        </a>
                    </li>

                    <li style="bottom: 30px;" class="absolute w-full mr-2">
                        <form action="{{ route('admin.logout') }}" method="POST"
                            class="flex items-center justify-center mr-3">
                            @csrf
                            <button type="submit" class="flex items-center">
                                <span class="text-red-500">Log Out</span>
                            </button>
                        </form>
                    </li>
                </ul>

            </div>
        </aside>


        <div class="flex flex-col sm:flex-row sm:ml-48 mr-9">

            <!-- Dynamic Toast -->
            @if (session('success') || session('error') || session('warning'))
                @php
                    $message = session('success') ?? (session('error') ?? session('warning'));
                    $messageType = session('success') ? 'success' : (session('error') ? 'error' : 'warning');
                    $bgColor =
                        $messageType === 'success'
                            ? 'bg-green-100'
                            : ($messageType === 'error'
                                ? 'bg-red-100'
                                : 'bg-orange-50');
                    $textColor =
                        $messageType === 'success'
                            ? 'text-green-500'
                            : ($messageType === 'error'
                                ? 'text-red-500'
                                : 'text-orange-500');
                    $icon =
                        $messageType === 'success'
                            ? 'sucsses.svg'
                            : ($messageType === 'error'
                                ? 'wrong.svg'
                                : 'warning.svg');
                    $messageTitle =
                        $messageType === 'success' ? 'Success' : ($messageType === 'error' ? 'Error!' : 'Oops!');
                @endphp
                <div id="toast-message"
                    style="position: fixed; top: 80px; right: 20px; z-index: 9999; transform: translateX(0);"
                    class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-xl shadow-sm border border-gray-50 transition-transform duration-500 ease-in-out"
                    role="alert">
                    <div
                        class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 {{ $textColor }} {{ $bgColor }} rounded-full">
                        <img class="w-5 h-5" src="{{ asset('assets/images/' . $icon) }}"
                            alt="{{ $messageTitle }} Icon">
                        <span class="sr-only">{{ $messageTitle }} icon</span>
                    </div>
                    <div class="ms-3 text-sm font-normal">
                        <p class="{{ $textColor }} text-sm font-medium">{{ $messageTitle }}</p>
                        <span class="text-gray-500 text-xs font-normal">{{ $message }}</span>
                    </div>
                    <button type="button"
                        class="ms-auto -mx-3 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8"
                        aria-label="Close" onclick="this.parentElement.style.display='none'">
                        <span class="sr-only">Close</span>
                        <img class="w-3 h-3" src="{{ asset('assets/images/delete.svg') }}" alt="Close Icon">
                    </button>
                </div>
            @endif


            @yield('content')



        </div>

    </div>
    <!-- end main content -->

    <!-- scripts assets -->
    <!-- === Flowbite JS === -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pagedone@1.2.1/src/js/pagedone.js"></script>
    <!-- === End Flowbite JS === -->
    <!-- === Custom JS === -->
    <script src="{{ asset('assets/js/showpass.js') }}"></script>
    <script src="{{ asset('assets/js/showcolumn.js') }}"></script>
    <!-- === End Custom JS === -->

</body>

</html>
