<x-header></x-header>
<x-layout>

<div class="bg-gray-100 min-h-screen flex flex-col pt-4 sm:pt-6">

    <main class="flex-grow container mx-auto px-4 sm:px-6 max-w-6xl pb-20 sm:pb-24">

        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mb-6 sm:mb-8 text-center pt-4 sm:pt-8">
            Complete Your Order
        </h1>

        {{--
            KEY CHANGE: The <form> now wraps the entire Grid system.
            This allows the inputs to be on the left, and the submit button
            to be in the sidebar on the right.
        --}}
        <form action="{{ isset($isDirectCheckout) && $isDirectCheckout ? route('checkout.processDirect') : route('checkout.process') }}" method="POST">
            @csrf

            {{-- If this is a direct checkout, silently pass the product ID and quantity to the final processor --}}
            @if(isset($isDirectCheckout) && $isDirectCheckout)
                <input type="hidden" name="product_id" value="{{ $directProductId }}">
                <input type="hidden" name="quantity" value="{{ $directQuantity }}">
            @endif
            

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT COLUMN: SHIPPING INFO --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Card: Customer Details --}}
                    <div class="bg-white rounded-xl shadow-lg p-5 sm:p-6 border border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2"> Shipping Information</h2>

                        <div class="grid grid-cols-1 gap-6">

                            {{-- Full Name --}}
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" id="full_name" name="full_name" required value="{{ old('full_name') }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 border">
                                @error('full_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                                <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 border">
                                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Address Line 1 --}}
                            <div>
                                <label for="address_line_1" class="block text-sm font-medium text-gray-700 mb-1">Address Line 1 *</label>
                                <input type="text" id="address_line_1" name="address_line_1" required value="{{ old('address_line_1') }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 border">
                                @error('address_line_1') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Address Line 2 --}}
                            <div>
                                <label for="address_line_2" class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 (Optional)</label>
                                <input type="text" id="address_line_2" name="address_line_2" value="{{ old('address_line_2') }}"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 border">
                                @error('address_line_2') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- City & Postcode Row --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Town/City *</label>
                                    <input type="text" id="city" name="city" required value="{{ old('city') }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 border">
                                    @error('city') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="postcode" class="block text-sm font-medium text-gray-700 mb-1">Postcode *</label>
                                    <input type="text" id="postcode" name="postcode" required value="{{ old('postcode') }}"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 border">
                                @error('postcode') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                     {{-- Card details --}}
                     <div class="bg-white rounded-xl shadow-lg p-5 sm:p-6 border border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2"> Payment Details </h2>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1"> Card Number *</label>
                                <input class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-3 border"
                                type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required value="{{ old('card_number') }}" />
                                @error('card_number') <p class="text-red-500  text-sm mt-1"> {{ $message }} </p> @enderror
</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                     {{-- Expiry date and CVV --}}
                            <div>
                                <label for="expiry_number" class="block text-sm font-medium text-gray-700 mb-1"> Expiry Date *</label>
                                <input class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-3 border"
                                type="text" id="expiry_number" name="expiry_number" placeholder="MM/YY" required value="{{ old('expiry_number') }}" />
                                @error('expiry_number') <p class="text-red-500  text-sm mt-1"> {{ $message }} </p> @enderror
</div>
                            <div>
                                <label for="cvv_number" class="block text-sm font-medium text-gray-700 mb-1"> CVV *</label>
                                <input class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-3 border"
                                type="text" id="cvv_number" name="cvv_number" placeholder="123" required value="{{ old('cvv_number') }}" />
                                @error('cvv_number') <p class="text-red-500  text-sm mt-1"> {{ $message }} </p> @enderror
    </div>
</div>
                    {{-- Name on Card --}}
                    <div>
                                <label for="card_name" class="block text-sm font-medium text-gray-700 mb-1"> Name on Card *</label>
                                <input class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-3 border"
                                type="text" id="card_name" name="card_name" required value="{{ old('card_name') }}" />
                                @error('card_name') <p class="text-red-500  text-sm mt-1"> {{ $message }} </p> @enderror
</div>

    </div>
</div>

                    {{-- Card: Shipping Method --}}
                    <div class="bg-white rounded-xl shadow-lg p-5 sm:p-6 border border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2"> Delivery Method</h2>

                        <div class="space-y-4">
                            <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" id="standard" name="delivery_method" value="standard" required checked
                                    class="h-5 w-5 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                <label for="standard" class="ml-3 flex flex-col cursor-pointer w-full">
                                    <span class="block text-sm font-bold text-gray-900">Standard Delivery (£3.95)</span>
                                    <span class="block text-sm text-gray-500">3-5 working days</span>
                                </label>
                            </div>

                            <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <input type="radio" id="express" name="delivery_method" value="express"
                                    class="h-5 w-5 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                <label for="express" class="ml-3 flex flex-col cursor-pointer w-full">
                                    <span class="block text-sm font-bold text-gray-900">Express Delivery (£6.95)</span>
                                    <span class="block text-sm text-gray-500">1-2 working days</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: ORDER SUMMARY (STICKY) --}}
                <aside class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-5 sm:p-6 border rounded-xl shadow-lg lg:sticky lg:top-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-3"> Order Summary</h2>

                        {{-- Item List (Mini) --}}
                        <div class="max-h-60 overflow-y-auto mb-4 pr-1 sm:pr-2 space-y-3 custom-scrollbar">
                            @forelse ($cartItems as $item)
                                <div class="flex justify-between items-center text-sm">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-800 truncate w-32 sm:w-40">{{ $item['name'] }}</div>
                                        <div class="text-gray-500">Qty: {{ $item['quantity'] }}</div>
                                    </div>
                                    <div class="font-semibold text-gray-700">
                                        £{{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Your cart is empty.</p>
                            @endforelse
                        </div>

                        <hr class="border-gray-200 mb-4">

                        {{-- Totals Calculation --}}
                        <div class="space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal:</span>
                                <span>£<span id="subtotal">{{ number_format($subtotal, 2) }}</span></span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping:</span>
                                <span>£<span id="shipping-display">3.95</span></span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-between text-xl font-extrabold text-gray-800 mb-6">
                                <span>Total:</span>
                                <span>£<span id="final-total"></span></span>
                            </div>

                            <button type="submit"
                                class="w-full text-center bg-indigo-600 text-white text-lg p-3 rounded-lg shadow-lg hover:bg-indigo-700 transition duration-200 font-bold">
                                Confirm & Pay
                            </button>

                            <p class="text-xs text-center text-gray-500 mt-3">
                                By clicking Confirm, you agree to our Terms & Conditions.
                            </p>
                        </div>
                    </div>
                    <a href="/basket"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-center text-sm font-bold text-gray-700 shadow-sm transition hover:bg-gray-100">
                        Back to Basket
                    </a>
                </aside>

            </div>
        </form>

    </main>

    {{-- Script remains mostly the same, just targeting the existing IDs --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const shippingRadios = document.querySelectorAll('input[name="delivery_method"]');
            const subtotalElement = document.getElementById('subtotal');
            const shippingDisplayElement = document.getElementById('shipping-display');
            const finalTotalElement = document.getElementById('final-total');

            // Get subtotal from the rendered PHP value (removing commas if present)
            const initialSubtotal = parseFloat(subtotalElement.textContent.replace(/[£,]/g, ''));

            function updateTotals() {
                // Get the cost of the currently selected shipping radio button
                const selectedRadio = document.querySelector('input[name="delivery_method"]:checked');
                if(!selectedRadio) return;

                //made a delivery price map that assigns the value of the delivery method chosen
                const deliveryPrices = {
                    standard: 3.95,
                    express: 6.95
                };

                let selectedShippingCost = deliveryPrices[selectedRadio.value];


                // Update display values
                shippingDisplayElement.textContent = selectedShippingCost.toFixed(2);

                // Calculate Final Total
                const newTotal = initialSubtotal + selectedShippingCost;
                finalTotalElement.textContent = newTotal.toFixed(2);
            }

            // Attach event listener to update totals whenever a shipping option is changed
            shippingRadios.forEach(radio => {
                radio.addEventListener('change', updateTotals);
            });

            // Run once on load
            updateTotals();
        });
    </script>
</div>

</x-layout>
<x-footer></x-footer>
