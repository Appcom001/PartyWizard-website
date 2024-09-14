<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party Wizard - Login</title>

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

</head>

<body class=" bg-custoum-body min-h-screen flex items-center justify-center">

    <!-- main content -->
    <div class="container m-auto flex flex-col items-center justify-center">
        <div class="card p-6 sm:max-w-sm md:max-w-md w-full">
            <div class="card-body flex flex-col items-center justify-start gap-3">
                <img src="{{ asset('assets/images/logo_out_text.svg') }}" alt="Party Wizard Logo"
                    class="mb-5 ms-3 w-25">

                <form class="w-full" method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <p class="block mb-2 ms-1 text-lg font-medium text-login">Admin Login</p>

                    <!-- email input -->
                    <div class="flex mb-4 email-container">
                        <span
                            class="inline-flex items-center px-2 text-sm border-span-input-log border-custom-input bg-white rounded-l-xl">
                            <img class="w-8 p-2 bg-custoum-orange-50 rounded-md"
                                src="{{ asset('assets/images/loginreg/email.svg') }}" alt="Email Icon">
                        </span>
                        <input type="email" name="email" id="email"
                            class="focus:outline-none focus:ring-0 text-gray-500 border-rad-custom-input border-custom-input bg-white block flex-1 min-w-0 w-full text-sm text-gray-900 p-4 rounded-r-xl"
                            placeholder="E-mail" autocomplete="off" required>

                    </div>
                    <!-- Display password error -->
                    @error('email')
                        <p class="text-red-500 text-xs -mt-3 mb-3">{{ $message }}</p>
                    @enderror

                    <!-- password input -->
                    <div class="flex mb-4 password-container">
                        <span
                            class="inline-flex items-center px-2 text-sm border-span-input-log border-custom-input bg-white rounded-l-xl">
                            <img class="w-9 p-2 bg-custoum-orange-50 rounded-md"
                                src="{{ asset('assets/images/loginreg/pass.svg') }}" alt="Password Icon">
                        </span>
                        <div class="relative flex-1">
                            <input type="password" name="password" id="password"
                                class="focus:outline-none focus:ring-0 text-custom-orange border-rad-custom-input border-custom-input bg-white block min-w-0 w-full text-sm p-4 rounded-r-xl"
                                placeholder="Password" autocomplete="off" required>
                            <span id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-300 cursor-pointer">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>

                    </div>

                    <!-- Display password error -->
                    @error('password')
                        <p class="text-red-500 text-xs -mt-3 mb-3">{{ $message }}</p>
                    @enderror

                    <button type="submit"
                        class="w-full bg-custom-orange text-white py-3.5 shadow-custom px-4 rounded-full hover:bg-blue-600 focus:outline-none">Login</button>
                </form>

                <div class="container mx-auto text-center mt-2">
                    <p class="text-gray-500">
                        Are you a new user?
                        <a href="{{ route('admin.showreg') }}"
                            class="text-custom-orange hover:text-gray-400 duration-300 underline">Register</a>
                    </p>
                </div>


            </div>
        </div>
    </div>
    <!-- end main content -->

    <!-- scripts assets -->

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- === End jQuery === -->

    <!-- === Flowbite JS === -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <!-- === End Flowbite JS === -->

    <!-- === Custom JS === -->
    <script src="{{ asset('assets/js/showpass.js') }}"></script>
    <!-- === End Custom JS === -->

</body>

</html>
