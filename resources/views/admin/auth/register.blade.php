<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party Wizard - Register</title>

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
    <div class=" m-auto flex flex-col items-center justify-center">
        <div class="card   w-full">
            <div class="card-body flex flex-col items-center justify-start gap-3 w-full">
                <div class="flex flex-col justify-center items-center">
                    <img src="{{ asset('assets/images/logo_out_text.svg') }}" alt="Party Wizard Logo"
                        class="mb-5 ms-3 w-24">
                    <span class="text-sm font-semibold">Create Store</span>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>

                <!-- Tabs Navigation -->
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex space-x-20 -mb-px text-sm font-medium text-center w-full" id="default-tab"
                        data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="flex-1" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg w-full text-md" id="profile-tab"
                                data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                                aria-selected="false">Country</button>
                        </li>
                        <li class="flex-1" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg w-full text-md hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                                aria-controls="dashboard" aria-selected="false">Store</button>
                        </li>
                        <li class="flex-1" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg w-full text-md hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                                aria-controls="settings" aria-selected="false">Document</button>
                        </li>
                        <li class="flex-1" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg w-full text-md hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab"
                                aria-controls="contacts" aria-selected="false">Bank</button>
                        </li>
                        <li class="flex-1" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg w-full text-md hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                id="vat-tab" data-tabs-target="#vat" type="button" role="tab" aria-controls="vat"
                                aria-selected="false">VAT</button>
                        </li>
                    </ul>
                </div>


                <!-- Tabs Content -->
                <div id="default-tab-content " style="width: 100%;max-width: 700px;">
                    {{-- form reg --}}
                    <form action="{{ route('admin.register') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Country Tab Content -->
                        <div role="tabpanel" class=" rounded-lg bg-gray-50 dark:bg-gray-800 w-full" id="Country">
                            <div
                                class="bg-white shadow-sm h-auto  w-full rounded-lg mx-auto py-10 px-5 flex flex-col justify-between">
                                <!-- Content -->
                                <div class="flex flex-col items-center h-full">
                                    <p class="text-lg text-gray-500 dark:text-gray-400 text-center mb-10">Where is your
                                        business based?</p>

                                    <div class="w-full max-w-md mx-auto">
                                        <label for="country-select"
                                            class="block mb-2 text-gray-600 text-sm font-medium">Select Country</label>

                                        <select id="country-select" name="country"
                                            class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg focus:outline-none">
                                            <option value="us">United States</option>
                                            <option value="ca">Canada</option>
                                            <option value="gb">United Kingdom</option>
                                            <option value="au">Australia</option>
                                            <option value="de">Germany</option>
                                            <option value="fr">France</option>
                                            <option value="es">Spain</option>
                                            <option value="it">Italy</option>
                                            <option value="jp">Japan</option>
                                            <option value="cn">China</option>
                                            <option value="in">India</option>
                                            <!-- Add more countries as needed -->
                                        </select>
                                    </div>
                                </div>

                                <!-- Proceed Button -->
                                <div class="flex items-end justify-end mt-16">
                                    <button id="go-to-store" type="button" onclick="showTab('store')"
                                        class="w-1/3 bg-custom-orange text-white py-3.5 shadow-custom px-4 rounded-full hover:bg-blue-600 focus:outline-none">Proceed
                                        to store</button>
                                </div>
                            </div>
                        </div>

                        <!-- Store Tab Content -->
                        <div role="tabpanel" class="hidden rounded-lg bg-gray-50 dark:bg-gray-800 w-full"
                            id="store" aria-labelledby="dashboard-tab">
                            <div
                                class="bg-white shadow-sm h-auto w-full rounded-lg mx-auto py-10 px-5 flex flex-col justify-between">
                                <!-- Content -->
                                <div class="flex flex-col items-center h-full">
                                    <p class="text-lg text-gray-500 dark:text-gray-400 text-center mb-10">Enter Your
                                        Store
                                        Details</p>

                                    <div class="w-full max-w-md mx-auto">
                                        <!-- Email -->
                                        <div class="mb-4">
                                            <label for="store-email"
                                                class="block mb-2 text-gray-600 text-sm font-medium">Email</label>
                                            <input type="email" id="store-email" name="email"
                                                placeholder="alan.gordon@mail.com"
                                                class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg focus:outline-none">
                                        </div>

                                        <!-- password -->
                                        <div class="mb-4">
                                            <label for="store-email"
                                                class="block mb-2 text-gray-600 text-sm font-medium">password</label>
                                            <input type="password" id="password-email" name="password"
                                                placeholder="enter passowrd"
                                                class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg focus:outline-none">
                                        </div>

                                        <!-- First Name -->
                                        <div class="mb-4">
                                            <label for="first-name"
                                                class="block mb-2 text-gray-600 text-sm font-medium">First Name</label>
                                            <input type="text" id="first-name" name="first_name"
                                                class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg focus:outline-none"
                                                placeholder="Enter your first name" required>
                                        </div>

                                        <!-- Last Name -->
                                        <div class="mb-4">
                                            <label for="last-name"
                                                class="block mb-2 text-gray-600 text-sm font-medium">Last Name</label>
                                            <input type="text" id="last-name" name="last_name"
                                                class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg focus:outline-none"
                                                placeholder="Enter your last name" required>
                                        </div>

                                        <!-- Store Name -->
                                        <div class="mb-4">
                                            <label for="store-name"
                                                class="block mb-2 text-gray-600 text-sm font-medium">What is your store
                                                name?</label>
                                            <input type="text" id="store-name" name="store_name"
                                                class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg focus:outline-none"
                                                placeholder="Enter your store name" required>
                                        </div>

                                        <!-- Company Legal Name -->
                                        <div class="mb-4">
                                            <label for="company-legal-name"
                                                class="block mb-2 text-gray-600 text-sm font-medium">Company legal
                                                name</label>
                                            <input type="text" id="company-legal-name" name="company_legal_name"
                                                class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg focus:outline-none"
                                                placeholder="Enter company legal name" required>
                                        </div>

                                        <!-- Company Phone Number -->
                                        <div class="mb-4">
                                            <label for="company-phone-number"
                                                class="block mb-2 text-gray-600 text-sm font-medium">Company phone
                                                number</label>
                                            <input type="tel" id="company-phone-number"
                                                name="company_phone_number"
                                                class="block w-full h-11 px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg focus:outline-none"
                                                placeholder="Enter company phone number" required>
                                        </div>

                                        <!-- Full Address -->
                                        <div class="mb-4">
                                            <label for="full-address"
                                                class="block mb-2 text-gray-600 text-sm font-medium">Enter your full
                                                address</label>
                                            <textarea id="full-address" name="full_address" rows="4"
                                                class="block w-full px-5 py-2.5 text-sm font-normal text-gray-500 bg-transparent border border-gray-300 rounded-lg focus:outline-none"
                                                placeholder="Enter your full address" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="flex items-end justify-between mt-10">
                                    <button type="button" id="go-back" data-back
                                        class="w-1/4 border-custom-orange py-3.5 rounded-full  focus:outline-none"
                                        onclick="showTab('Country')">Back</button>
                                    <button type="button" id="go-to-document"
                                        class="w-1/3 bg-custom-orange text-white py-3.5 shadow-custom px-4 rounded-full hover:bg-blue-600 focus:outline-none"
                                        onclick="showTab('docs')">Proceed
                                        to Document</button>
                                </div>
                            </div>
                        </div>


                        <!-- Document Tab Content -->
                        <div role="tabpanel" class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 w-full"
                            id="docs">
                            <div
                                class="bg-white shadow-sm h-auto w-full rounded-lg mx-auto py-10 px-5 flex flex-col justify-between">
                                <!-- Content -->
                                <div class="flex flex-col items-center">
                                    <p class="text-lg text-gray-500 dark:text-gray-400 text-center mb-10">Upload your
                                        business documents</p>

                                    <!-- Upload Trade Licence -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="trade-licence"
                                            class="block mb-2 text-gray-600 text-sm font-medium">Upload Trade
                                            Licence</label>
                                        <input type="file" id="trade-licence" name="trade_licence"
                                            class="block w-full text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg focus:outline-none">
                                    </div>

                                    <!-- Upload National ID -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="national-id"
                                            class="block mb-2 text-gray-600 text-sm font-medium">Upload National ID
                                            (Emirates ID, Saudi Iqama or Passport copy with VISA)</label>
                                        <input type="file" id="national-id" name="national_id"
                                            class="block w-full text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg focus:outline-none">
                                    </div>
                                </div>

                                <!-- Proceed Button -->
                                <div class="flex items-end justify-between mt-10">
                                    <button type="button" id="go-back" data-back
                                        class="w-1/4 border-custom-orange py-3.5 rounded-full  focus:outline-none"
                                        onclick="showTab('store')">Back</button>
                                    <button type="button" id="go-to-bank"
                                        class="w-1/3 bg-custom-orange text-white py-3.5 shadow-custom px-4 rounded-full hover:bg-blue-600 focus:outline-none"
                                        onclick="showTab('bank-details')">Proceed
                                        to Bank</button>
                                </div>
                            </div>
                        </div>


                        <!-- Bank Tab Content -->
                        <div role="tabpanel" class="p-4 hidden rounded-lg bg-gray-50 dark:bg-gray-800 w-full"
                            id="bank-details">
                            <div
                                class="bg-white shadow-sm h-auto w-full rounded-lg mx-auto py-10 px-5 flex flex-col justify-between">
                                <!-- Content -->
                                <div class="flex flex-col items-center">
                                    <p class="text-lg text-gray-500 dark:text-gray-400 text-center mb-10">Enter Bank
                                        Details</p>

                                    <!-- Beneficiary Name -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="beneficiary-name"
                                            class="block mb-2 text-gray-600 text-sm font-medium">Beneficiary
                                            Name</label>
                                        <input type="text" id="beneficiary-name" name="beneficiary_name"
                                            class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                            placeholder="Enter beneficiary name" required>
                                    </div>

                                    <!-- Payoneer Email -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="payoneer-email"
                                            class="block mb-2 text-gray-600 text-sm font-medium">Payoneer Email</label>
                                        <input type="email" id="payoneer-email" name="payoneer_email"
                                            class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                            placeholder="Enter Payoneer email" required>
                                    </div>

                                    <!-- Bank Name -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="bank-name"
                                            class="block mb-2 text-gray-600 text-sm font-medium">Bank
                                            Name</label>
                                        <input type="text" id="bank-name" name="bank_name"
                                            class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                            placeholder="Enter bank name" required>
                                    </div>

                                    <!-- Branch Name -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="branch-name"
                                            class="block mb-2 text-gray-600 text-sm font-medium">Branch Name</label>
                                        <input type="text" id="branch-name" name="branch_name"
                                            class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                            placeholder="Enter branch name" required>
                                    </div>

                                    <!-- Account Number -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="account-number"
                                            class="block mb-2 text-gray-600 text-sm font-medium">Account Number</label>
                                        <input type="text" id="account-number" name="account_number"
                                            class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                            placeholder="Enter account number" required>
                                    </div>

                                    <!-- IBAN Number -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="iban-number"
                                            class="block mb-2 text-gray-600 text-sm font-medium">IBAN
                                            Number</label>
                                        <input type="text" id="iban-number" name="iban_number"
                                            class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                            placeholder="Enter IBAN number" required>
                                    </div>

                                    <!-- Swift Code -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="swift-code"
                                            class="block mb-2 text-gray-600 text-sm font-medium">Swift
                                            Code</label>
                                        <input type="text" id="swift-code" name="swift_code"
                                            class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                            placeholder="Enter Swift code" required>
                                    </div>

                                    <!-- Currency -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="currency-select"
                                            class="block mb-2 text-gray-600 text-sm font-medium">Select
                                            Currency</label>
                                        <select id="currency-select" name="currency"
                                            class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg focus:outline-none">
                                            <option value="usd">USD - United States Dollar</option>
                                            <option value="eur">EUR - Euro</option>
                                            <option value="gbp">GBP - British Pound</option>
                                            <option value="jpy">JPY - Japanese Yen</option>
                                            <!-- Add more currencies as needed -->
                                        </select>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="flex items-end justify-between mt-16">
                                    <button type="button" id="go-back" data-back
                                        class="w-1/4 border-custom-orange py-3.5 rounded-full focus:outline-none"
                                        onclick="showTab('docs')">Back</button>
                                    <button type="button" id="go-to-vat"
                                        class="w-1/3 bg-custom-orange text-white py-3.5 shadow-custom px-4 rounded-full focus:outline-none"
                                        onclick="showTab('vat')">Proceed to Vat</button>
                                </div>
                            </div>
                        </div>

                        <!-- VAT Tab Content -->
                        <div role="tabpanel" class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 w-full"
                            id="vat">
                            <div
                                class="bg-white shadow-sm h-auto w-full rounded-lg mx-auto py-10 px-5 flex flex-col justify-between">
                                <!-- Content -->
                                <div class="flex flex-col items-center">
                                    <p class="text-lg text-gray-500 dark:text-gray-400 text-center mb-10">VAT Details
                                    </p>

                                    <!-- Tax Registration Number -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="tax-registration-number"
                                            class="block mb-2 text-gray-600 text-sm font-medium">Tax Registration
                                            Number</label>
                                        <input type="text" id="tax-registration-number"
                                            name="tax_registration_number"
                                            class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none"
                                            placeholder="Enter Tax Registration Number" required>
                                    </div>

                                    <!-- Upload Tax Registration Certificate -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="tax-registration-certificate"
                                            class="block mb-2 text-gray-600 text-sm font-medium">Upload Tax
                                            Registration
                                            Certificate</label>
                                        <input type="file" id="tax-registration-certificate"
                                            name="tax_certificate"
                                            class="block w-full px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none">
                                    </div>

                                    <!-- Agreement Checkbox -->
                                    <div class="w-full max-w-md mx-auto mb-6">
                                        <label for="vat-agreement" class="ml-2 text-gray-500 text-sm font-medium">I
                                            acknowledge and agree that (Brand name here) will be raising and
                                            facilitating
                                            VAT invoices and credit notes on behalf of my company in relation to
                                            consumer
                                            transactions on the (brand name here) site</label>

                                        <div class="flex items-center mt-3">
                                            <input type="checkbox" id="vat-agreement" name="vat_agreement"
                                                class="w-4 h-4 text-custom-orange border-gray-300 rounded focus:ring-custom-orange"
                                                required>
                                            <span class="text-gray-700 font-semibold text-xs ms-2">I agree</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="flex items-end justify-between mt-16">
                                    <button type="button" id="go-back" data-back
                                        class="w-1/4 border-custom-orange py-3.5 rounded-full focus:outline-none"
                                        onclick="showTab('bank-details')">Back</button>
                                    <button type="submit" id="submit-form"
                                        class="w-1/3 bg-custom-orange text-white py-3.5 shadow-custom px-4 rounded-full focus:outline-none">Submit</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- JavaScript for Tabs -->
                    <script>
                        function showTab(tabId) {
                            const tabs = document.querySelectorAll('[role="tabpanel"]');
                            tabs.forEach(tab => tab.classList.add('hidden')); // إخفاء جميع التبويبات

                            document.getElementById(tabId).classList.remove('hidden'); // عرض التبويب المطلوب
                        }
                    </script>


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
    <script src="{{ asset('assets/js/reg.js') }}"></script>
    <!-- === End Custom JS === -->

</body>

</html>
