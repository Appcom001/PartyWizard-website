<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success - Party Wizard</title>

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

<body class="bg-custoum-body min-h-screen flex items-center justify-center">
    <!-- main content -->
    <div class="container m-auto flex flex-col items-center justify-center">
        <div class="card p-6 max-w-xl w-full">
            <div class="card-body flex flex-col items-center justify-start gap-3">
                <img src="{{ asset('assets/images/loginreg/done.svg') }}" alt="Payment Success"
                    class="mb-3 w-56 md:w-28">

                <div class="w-full">

                    <div class="text-center mt-2 mb-4">
                        <p class="text-custom-orange mb-2 font-bold text-2xl">Payment Successful!</p>
                        <p class="text-gray-500 text-lg">Thank you for your purchase. Your transaction was successful,
                            and we look forward to serving you again soon!</p>
                    </div>

                    <div class="px-16">
                        <div class="px-3.5 mt-5 pt-5">
                            <a href="{{ route('home') }}"
                                class="w-full bg-custom-orange flex justify-center items-center text-white py-3.5 shadow-custom rounded-full">
                                Continue Marketing</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- end main content -->

    <!-- scripts assets -->

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- === Flowbite JS === -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <!-- === End Flowbite JS === -->


</body>

</html>
