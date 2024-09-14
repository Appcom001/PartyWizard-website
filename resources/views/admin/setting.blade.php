<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party Wizard - CPanel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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


</head>

<body style="background-color: rgb(237, 237, 237) !important;">

    <!-- main content -->
    <div class="mx-auto max-w-screen-2xl 	">
        <aside id="logo-sidebar"
            class="fixed top-0 left-0 z-40 w-44 h-screen transition-transform -translate-x-full sm:translate-x-0"
            aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center ps-2.5 mb-5">
                    <img src="{{asset('assets/images/logo_out_text.svg')}}" class="me-3 h-12" alt="Logo" />
                </a>
                <ul class="space-y-7 font-medium mt-10">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center p-2 text-gray-400 rounded-lg  hover:bg-gray-100 dark:hover:bg-gray-700 group">
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
                            class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <i class="fas fa-chart-pie w-5 h-5  text-gray-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap text-gray-400">Analytics</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.products.index') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <i class="fas fa-cube w-5 h-5  text-gray-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap text-gray-400">Products</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.settings') }}"
                            class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <i class="fas fa-cog w-5 h-5   text-custom-orange "></i>
                            <span class="flex-1 ms-3 whitespace-nowrap text-custom-orange">Settings</span>
                        </a>
                    </li>

                </ul>
            </div>
        </aside>

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
                    <img class="w-5 h-5" src="{{ asset('assets/images/' . $icon) }}" alt="{{ $messageTitle }} Icon">
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

        <div class="flex flex-col sm:flex-row sm:ml-48 mr-5 ">

            <!-- tabs -->
            <div class=" bg-white  w-full rounded-lg p-6 mt-3  ">
                <div class="tabs ">
                    <div class="block">
                        <ul class="flex w-full space-x-3 transition-all duration-300 -mb-px">
                            <li>
                                <a href="javascript:void(0)"
                                    class="text-md mx-5 inline-block py-4 px-6 text-gray-500 hover:text-gray-800 font-medium border-b-2 border-transparent tab-active:border-b-indigo-600 tab-active:text-indigo-600 active tablink whitespace-nowrap"
                                    data-tab="tabs-with-underline-1" role="tab"> Login Info </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"
                                    class="inline-block py-4 px-6 mx-5 text-gray-500 hover:text-gray-800 font-medium border-b-2 border-transparent tab-active:border-b-indigo-600 tab-active:text-indigo-600 tablink whitespace-nowrap"
                                    data-tab="tabs-with-underline-2" role="tab"> Seller details </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"
                                    class="inline-block py-4 px-6 mx-5 text-gray-500 hover:text-gray-800 font-medium border-b-2 border-transparent tab-active:border-b-indigo-600 tab-active:text-indigo-600 tablink whitespace-nowrap"
                                    data-tab="tabs-with-underline-3" role="tab"> Bank </a>
                            </li>
                        </ul>
                    </div>
                    <div
                        class=" bg-white rounded-lg top-40 absolute left-48 right-5 ml-96 h-auto   mx-auto max-w-screen-2xl	">
                        <div id="tabs-with-underline-3" class="hidden tabcontent" role="tabpanel"
                            aria-labelledby="tabs-with-underline-item-3">
                            <div class="p-4">
                                <p class="text-gray-500 dark:text-gray-400">Bank Details</p>

                                <!-- Form Section -->
                                <div class="bg-white rounded-lg p-6 mt-3">
                                    <form method="POST" action="{{ route('admin.settings.updateBankDetails') }}">
                                        @csrf <!-- حماية ضد الهجمات CSRF -->

                                        <div class="flex gap-10 mt-5">
                                            <!-- Column 1 -->
                                            <div class="flex flex-col gap-6 w-1/3">
                                                <!-- Beneficiary Name -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">
                                                        Beneficiary name
                                                    </label>
                                                    <input type="text" id="beneficiary-name"
                                                        name="beneficiary_name"
                                                        class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter beneficiary name"
                                                        value="{{ old('beneficiary_name', $admin->beneficiary_name ?? '') }}"
                                                        required>
                                                </div>

                                                <!-- Account Number -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">
                                                        Account number
                                                    </label>
                                                    <input type="text" id="account-number" name="account_number"
                                                        class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter account number"
                                                        value="{{ old('account_number', $admin->account_number ?? '') }}"
                                                        required>
                                                </div>

                                                <!-- Payoneer Email -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">
                                                        Payoneer email
                                                    </label>
                                                    <input type="email" id="payoneer-email" name="payoneer_email"
                                                        class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter Payoneer email"
                                                        value="{{ old('payoneer_email', $admin->payoneer_email ?? '') }}"
                                                        required>
                                                </div>
                                            </div>

                                            <!-- Column 2 -->
                                            <div class="flex flex-col gap-6 w-1/3">
                                                <!-- IBAN Number -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">
                                                        IBAN Number
                                                    </label>
                                                    <input type="text" id="iban-number" name="iban_number"
                                                        class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter IBAN number"
                                                        value="{{ old('iban_number', $admin->iban_number ?? '') }}"
                                                        required>
                                                </div>

                                                <!-- Bank Name -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">
                                                        Bank name
                                                    </label>
                                                    <input type="text" id="bank-name" name="bank_name"
                                                        class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter bank name"
                                                        value="{{ old('bank_name', $admin->bank_name ?? '') }}"
                                                        required>
                                                </div>

                                                <!-- Swift Code -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">
                                                        Swift Code
                                                    </label>
                                                    <input type="text" id="swift-code" name="swift_code"
                                                        class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter Swift Code"
                                                        value="{{ old('swift_code', $admin->swift_code ?? '') }}"
                                                        required>
                                                </div>
                                            </div>

                                            <!-- Column 3 -->
                                            <div class="flex flex-col gap-6 w-1/3">
                                                <!-- Branch Name -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">
                                                        Branch name
                                                    </label>
                                                    <input type="text" id="branch-name" name="branch_name"
                                                        class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter branch name"
                                                        value="{{ old('branch_name', $admin->branch_name ?? '') }}"
                                                        required>
                                                </div>

                                                <!-- Currency -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">
                                                        Currency
                                                    </label>
                                                    <input type="text" id="currency" name="currency"
                                                        class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter currency"
                                                        value="{{ old('currency', $admin->currency ?? '') }}"
                                                        required>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                            </div>
                            <!-- Save Button -->
                            <div class="bg-white rounded-lg p-6 mt-10 absolute left-0 right-0">
                                <div class="flex items-center justify-between w-full mt-5">
                                    <div></div>
                                    <button type="submit"
                                        class="bg-custom-orange hover:bg-blue-700 text-white py-2 px-16 rounded-full">Save</button>
                                </div>
                            </div>
                            </form>

                        </div>



                        <div id="tabs-with-underline-1" role="tabpanel" aria-labelledby="tabs-with-underline-item-1"
                            class="tabcontent w-full">
                            <div class="tabs flex">
                                <div class="flex pt-10">
                                    <ul
                                        class="flex flex-col space-y-5 pr-5 w-64  transition-all duration-300 border-r-2 overflow-hidden">
                                        <li class="tabsemail w-64">
                                            <a href="javascript:void(0)"
                                                class="inline-block py-3 px-6 w-64  text-gray-500 hover:text-gray-800 font-medium  tab-active:bg-white tab-active:rounded-xl tab-active:text-indigo-600 active tablink whitespace-nowrap"
                                                data-tab="tabs-with-background-1" role="tab">Password </a>
                                        </li>
                                        <li class="tabsemail w-64">
                                            <a href="javascript:void(0)"
                                                class="inline-block py-3 px-6 w-64 text-gray-500 hover:text-gray-800 font-medium  tab-active:bg-white tab-active:rounded-xl tab-active:text-indigo-600 tablink whitespace-nowrap"
                                                data-tab="tabs-with-background-2" role="tab"> Email </a>
                                        </li>

                                    </ul>

                                </div>
                                <div class="mt-3 px-4 py-5">
                                    <!-- Tab 1: Password Update -->
                                    <div id="tabs-with-background-1" role="tabpanel"
                                        aria-labelledby="tabs-with-background-item-1" class="tabcontent">
                                        <p class="text-gray-500">
                                        <form action="{{ route('admin.settings.updatePassword') }}" method="POST">
                                            @csrf
                                            <div class="flex flex-col gap-6 mb-6 w-full ms-5">
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">Old
                                                        Password</label>
                                                    <input type="password" name="old_password" id="old-password"
                                                        class="block w-full h-11 px-5 py-2.5 leading-7 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Input your old password" required>
                                                </div>
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">New
                                                        Password</label>
                                                    <input type="password" name="new_password" id="new-password"
                                                        class="block w-full h-11 px-5 py-2.5 leading-7 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Input your new password" required>
                                                    <p class="text-xs text-gray-400 mt-1 ps-2">Min 8 Characters,
                                                        letters and numbers</p>
                                                </div>
                                                <div class="w-full relative mb-6">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">Confirm
                                                        New Password</label>
                                                    <input type="password" name="new_password_confirmation"
                                                        id="confirm-new-password"
                                                        class="block w-full h-11 px-5 py-2.5 leading-7 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Confirm new password" required>
                                                </div>
                                            </div>

                                            <!-- Save Button -->
                                            <div class="bg-white rounded-lg p-6 mt-10 absolute left-0 right-0">
                                                <div class="flex items-center justify-between w-full mt-5">
                                                    <div></div>
                                                    <button type="submit"
                                                        class="bg-custom-orange hover:bg-blue-700 text-white py-2 px-16 rounded-full">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                        </p>
                                    </div>

                                    <!-- Tab 2: Email Update -->
                                    <div id="tabs-with-background-2" class="hidden tabcontent" role="tabpanel"
                                        aria-labelledby="tabs-with-background-item-2">
                                        <p class="text-gray-500">
                                        <form action="{{ route('admin.settings.updateEmail') }}" method="POST">
                                            @csrf
                                            <div class="flex flex-col gap-6 mb-6 w-full ms-5">
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">Old
                                                        Email</label>
                                                    <input type="email" name="old_email"
                                                        class="block w-full h-11 px-5 py-2.5 leading-7 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Input your old email"
                                                        value="{{ old('old_email') ?? Auth::guard('admin')->user()->email }}"
                                                        required>
                                                </div>
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">New
                                                        Email</label>
                                                    <input type="email" name="email"
                                                        class="block w-full h-11 px-5 py-2.5 leading-7 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Input your new email"
                                                        value="{{ old('email') }}" required>
                                                </div>
                                            </div>

                                            <!-- Save Button -->
                                            <div class="bg-white rounded-lg p-6 mt-10 absolute left-0 right-0">
                                                <div class="flex items-center justify-between w-full mt-5">
                                                    <div></div>
                                                    <button type="submit"
                                                        class="bg-custom-orange hover:bg-blue-700 text-white py-2 px-16 rounded-full">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            </p>
                        </div>

                        <div id="tabs-with-underline-2" class="hidden tabcontent" role="tabpanel"
                            aria-labelledby="tabs-with-underline-item-2">
                            <div class="p-4">

                                <p class="text-gray-500 dark:text-gray-400">
                                    Seller details
                                </p>

                                <!-- Form Section -->
                                <div class="bg-white rounded-lg p-6 mt-3">
                                    <form action="{{ route('admin.settings.updateSellerDetails') }}" method="POST">
                                        @csrf
                                        <div class="flex gap-10 mt-5">
                                            <!-- Column 1 -->
                                            <div class="flex flex-col gap-6 w-2/3">
                                                <!-- First Name -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">First
                                                        Name</label>
                                                    <input type="text" name="first_name" id="first-name"
                                                        class="block w-full h-11  py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter your first name"
                                                        value="{{ old('first_name', $admin->first_name ?? '') }}"
                                                        required>
                                                </div>

                                                <!-- Last Name -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">Last
                                                        Name</label>
                                                    <input type="text" name="last_name" id="last-name"
                                                        class="block w-full h-11  py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter your last name"
                                                        value="{{ old('last_name', $admin->last_name ?? '') }}"
                                                        required>
                                                </div>

                                                <!-- Store Name -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">What
                                                        is your store name?</label>
                                                    <input type="text" name="store_name" id="store-name"
                                                        class="block w-full h-11  py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter your store name"
                                                        value="{{ old('store_name', $admin->store_name ?? '') }}"
                                                        required>
                                                </div>
                                            </div>

                                            <!-- Column 2 -->
                                            <div class="flex flex-col gap-6 w-2/3">
                                                <!-- Company Legal Name -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">Company
                                                        legal name</label>
                                                    <input type="text" name="company_legal_name"
                                                        id="company-legal-name"
                                                        class="block w-full h-11  py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter company legal name"
                                                        value="{{ old('company_legal_name', $admin->company_legal_name ?? '') }}"
                                                        required>
                                                </div>

                                                <!-- Company Phone Number -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">Company
                                                        phone number</label>
                                                    <input type="tel" name="company_phone_number"
                                                        id="company-phone-number"
                                                        class="block w-full h-11  py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter company phone number"
                                                        value="{{ old('company_phone_number', $admin->company_phone_number ?? '') }}"
                                                        required>
                                                </div>

                                                <!-- Full Address -->
                                                <div class="w-full relative">
                                                    <label
                                                        class="flex items-center mb-2 text-gray-600 text-sm font-medium">Enter
                                                        your full address</label>
                                                    <textarea name="full_address" id="full-address"
                                                        class="block w-full h-24  py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                                        placeholder="Enter your full address" required>{{ old('full_address', $admin->full_address ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- Save Button -->
                                        <div class="bg-white rounded-lg p-6 mt-7 absolute left-0 right-0">
                                            <div class="flex items-center justify-between w-full mt-5">
                                                <div></div>
                                                <button type="submit"
                                                    class="bg-custom-orange hover:bg-blue-700 text-white py-2 px-16 rounded-full">Save</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>




                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- end -->

    </div>
    <!-- end main content -->

    <!-- scripts assets -->

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- === End jQuery === -->

    <!-- === Flowbite JS === -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pagedone@1.2.1/src/js/pagedone.js"></script>
    <!-- === End Flowbite JS === -->



</body>

</html>
