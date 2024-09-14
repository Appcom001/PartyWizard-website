@extends('layouts.app')
@section('content')
    <!-- main -->
    <main>
        <div class="sm:ml-64 mlcustom">

            <div class=" px-4 pt-2.5 mt-3 flex items-start allmaindivs2 ">

                <!-- middle -->
                <div class="middle bg-white shadow-sm h-auto me-5 rounded-lg shadow-sm">

                    <div class="main-content bg-white h-auto me-5 shadow-sm rounded-lg p-4 w-full">
                        <h2 class="text-xl hidden sm:block font-semibold mb-5 text-gray-900 sm:text-2xl">
                            Checkout
                        </h2>

                        @if ($isCartEmpty)
                            <div class="alert alert-warning text-center text-red-500 py-4">
                                Your cart is empty. Please add items to your cart before proceeding to payment.
                            </div>
                            <div class="flex justify-center mt-4">
                                <a href="{{ route('home') }}" type="submit"
                                    class="flex items-center justify-center rounded-full bg-custom-orange px-6 py-3 text-md font-medium text-white shadow-custom hover:bg-orange-700 focus:outline-none">
                                    Shopping Now
                                </a>
                            </div>
                        @else
                            <div class="mb-4 border-b border-gray-200">
                                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                                    data-tabs-toggle="#default-tab-content" role="tablist">
                                    <li class="me-2" role="presentation">
                                        <button
                                            class="inline-flex items-center p-4 border-b-2 text-gray-400 border-gray-400 rounded-t-lg tab-button text-custom-orange active"
                                            id="billing-tab" data-tabs-target="#billing" type="button" role="tab"
                                            aria-controls="billing" aria-selected="true">
                                            <i class="fas fa-user me-2"></i> Billing Info
                                        </button>
                                    </li>
                                    <li class="me-2" role="presentation">
                                        <button
                                            class="inline-flex items-center p-4 border-b-2 text-gray-400 border-gray-400 rounded-t-lg tab-button"
                                            id="payment-tab" data-tabs-target="#payment" type="button" role="tab"
                                            aria-controls="payment" aria-selected="false">
                                            <i class="fas fa-credit-card me-2"></i> Payment
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div id="default-tab-content">
                                <form action="{{ route('checkout.store') }}" method="POST">
                                    @csrf

                                    <!-- Billing Info Tab -->
                                    <div class="p-4 rounded-lg" id="billing" role="tabpanel"
                                        aria-labelledby="billing-tab">
                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- First Name -->
                                            <div class="w-full relative">
                                                <span class="flex items-center mb-2 text-gray-600 text-sm font-medium">First
                                                    Name</span>
                                                <input type="text" name="first_name"
                                                    class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg"
                                                    placeholder="First Name" required>
                                            </div>
                                            <!-- Last Name -->
                                            <div class="w-full relative">
                                                <span class="flex items-center mb-2 text-gray-600 text-sm font-medium">Last
                                                    Name</span>
                                                <input type="text" name="last_name"
                                                    class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg"
                                                    placeholder="Last Name" required>
                                            </div>
                                            <!-- Country -->
                                            <div class="w-full relative">
                                                <span
                                                    class="flex items-center mb-2 text-gray-600 text-sm font-medium">Country</span>
                                                <input type="text" name="country"
                                                    class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg"
                                                    placeholder="Country Name" required>
                                            </div>
                                            <!-- City -->
                                            <div class="w-full relative">
                                                <span
                                                    class="flex items-center mb-2 text-gray-600 text-sm font-medium">City</span>
                                                <input type="text" name="city"
                                                    class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg"
                                                    placeholder="City Name" required>
                                            </div>
                                            <!-- Address 1 -->
                                            <div class="w-full relative">
                                                <span
                                                    class="flex items-center mb-2 text-gray-600 text-sm font-medium">Address
                                                    1</span>
                                                <input type="text" name="address1"
                                                    class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg"
                                                    placeholder="Street Address" required>
                                            </div>
                                            <!-- Address 2 -->
                                            <div class="w-full relative">
                                                <span
                                                    class="flex items-center mb-2 text-gray-600 text-sm font-medium">Address
                                                    2</span>
                                                <input type="text" name="address2"
                                                    class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg"
                                                    placeholder="Apartment, Suite, etc.">
                                            </div>
                                            <!-- Postal Code -->
                                            <div class="w-full relative">
                                                <span class="flex items-center mb-2 text-gray-600 text-sm font-medium">Post
                                                    Code</span>
                                                <input type="text" name="post_code"
                                                    class="block w-full h-11 px-5 py-2.5 text-sm text-gray-500 bg-transparent border border-gray-300 rounded-lg"
                                                    placeholder="Postal Code" required>
                                            </div>
                                        </div>

                                        <!-- Button to move to Payment Tab -->
                                        <div class="flex justify-end mt-4">
                                            <button type="button" onclick="showTab('payment')"
                                                class="flex items-center justify-center rounded-full bg-custom-orange px-6 py-3 text-md font-medium text-white shadow-custom hover:bg-orange-700 focus:outline-none">
                                                Next: Payment
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Payment Tab -->
                                    <div class="p-4 rounded-lg mt-4 hidden" id="payment" role="tabpanel"
                                        aria-labelledby="payment-tab">
                                        <div class="space-y-2">
                                            <span class="text-gray-500 text-sm font-semibold mb-4 ms-1">Select Payment
                                                Method:</span>

                                            <!-- Stripe Payment Option -->
                                            <div class="relative cursor-pointer bg-white/40 hover:bg-white/20 w-72 p-4 rounded-md flex justify-between items-center border-2 border-gray-200 transition-colors duration-300 ease-in-out payment-option"
                                                onclick="selectPaymentOption('stripe-option')">
                                                <div class="flex items-center space-x-5">
                                                    <img src="{{ asset('assets/images/Icon payment-stripe.svg') }}"
                                                        alt="Stripe" />
                                                </div>
                                                <input type="radio" id="stripe-option" name="payment_method"
                                                    value="stripe" class="absolute right-0 me-4 peer hidden" required />
                                                <span class="text-sm text-gray-500 font-semibold">
                                                    Stripe
                                                </span>
                                            </div>

                                            <!-- PayPal Payment Option -->
                                            <div class="relative cursor-pointer bg-white/40 hover:bg-white/20 w-72 p-4 rounded-md flex justify-between items-center border-2 border-gray-200 transition-colors duration-300 ease-in-out payment-option"
                                                onclick="selectPaymentOption('paypal-option')">
                                                <div class="flex items-center space-x-5">
                                                    <img src="{{ asset('assets/images/Icon awesome-paypal.svg') }}"
                                                        alt="PayPal" />
                                                </div>
                                                <input type="radio" id="paypal-option" name="payment_method"
                                                    value="paypal" class="absolute right-0 me-4 peer hidden" required />
                                                <span class="text-sm text-gray-500 font-semibold">
                                                    PayPal
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Navigation Buttons -->
                                        <div class="flex justify-between mt-9">
                                            <!-- Back Button -->
                                            <button type="button" onclick="showTab('billing')"
                                                class="px-6 hidden sm:block py-3 hover-blue text-md border-custom-blue font-medium rounded-full hover:text-white text-custom-blue">
                                                Back
                                            </button>

                                            <!-- Complete Payment Button -->
                                            <button type="submit"
                                                class="flex items-center justify-center rounded-full bg-custom-orange px-6 py-3 text-md font-medium text-white shadow-custom hover:bg-orange-700 focus:outline-none">
                                                Proceed to Payment
                                            </button>
                                        </div>
                                    </div>



                                </form>
                            </div>


                    </div>
                </div>

                <!-- right sec -->
                <div class="rightsec h-auto ms-5 bg-white rounded-lg shadow-sm p-2 px-3">
                    <div class="flex justify-center">
                        <p class="text-sm text-gray-500 mt-3">Order Summary</p>
                    </div>

                    <!-- Divider -->
                    <hr class="my-5">

                    <!-- Price Section -->
                    <div>
                        <div class="flex items-start justify-between mt-3 w-full">
                            <span class="font-medium text-gray-600 text-sm">Items subtotal :</span>
                            <span class="text-gray-500 text-sm font-semibold">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex items-start justify-between mt-3">
                            <span class="font-medium text-gray-600 text-sm">Discount:</span>
                            <span class="font-semibold text-custom-orange text-sm">{{ number_format($discount, 2) }}</span>
                        </div>
                    </div>
                    <!-- Divider -->
                    <hr class="my-7">

                    <!-- Total Section -->
                    <div>
                        <div class="flex items-start justify-between mt-3">
                            <span class="font-medium text-gray-600 text-sm">Total:</span>
                            <span class="font-bold text-custom-orange text-lg">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
                @endif

            </div>

        </div>

    </main>
    <!-- end main -->
@endsection('content')
@section('js')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- === End jQuery === -->

    <!-- === Flowbite JS === -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <!-- === End Flowbite JS === -->

    <!-- === Custom JS === -->

    <!-- === Carousel === -->
    <script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>
    <script src="assets/js/carousel.js"></script>
    <!-- === End Carousel === -->

    <script src="assets/js/tabs_bill.js"></script>
    <script src="assets/js/tabs.js"></script>
    <script>
        function selectPaymentOption(optionId) {
            document.getElementById(optionId).checked = true;
        }


        function selectPaymentOption(optionId) {
            document.getElementById(optionId).checked = true;
            document.querySelectorAll('.payment-option').forEach(el => {
                el.classList.remove('border-red-500', 'text-red-500');
            });
            document.getElementById(optionId).closest('.payment-option').classList.add('border-red-500', 'text-red-500');
        }

        function showTab(tabId) {
            document.getElementById('billing').classList.add('hidden');
            document.getElementById('payment').classList.add('hidden');
            document.getElementById(tabId).classList.remove('hidden');
        }
    </script>

    <!-- === End Custom JS === -->
@endsection
