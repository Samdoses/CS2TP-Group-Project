<!--Quantity, price. add to basket-->
<div class="purchase-block">
    <style>
        #quantity::-webkit-outer-spin-button,
        #quantity::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        #quantity[type='number'] {
            -moz-appearance: textfield;
            appearance: textfield;
        }
    </style>

    <div class="mb-4">
        <div class="flex flex-col gap-8 border-t border-b border-gray-800 py-8 sm:flex-row sm:items-end sm:justify-between sm:gap-10 sm:py-10">
            <div class="flex items-center gap-6 select-none text-4xl font-light">
                <div class="mb-4">
                    <label class="mb-4 block text-lg font-bold">Quantity</label>
                    <div class="flex items-center gap-4 text-3xl font-light sm:gap-6 sm:text-4xl">
                        @if ($stock != 0)
                            <button type="button" id="minus_quantity"> - </button>
                            <input
                                id="quantity"
                                name="quantity"
                                type="number"
                                inputmode="numeric"
                                value="1"
                                min="1"
                                max="{{ $stock }}"
                                class="mx-2 w-12 appearance-none border-none bg-transparent text-center focus:outline-none"
                            />
                            <button type="button" id="plus_quantity"> + </button>
                        @else
                            <button type="button" id="static_minus" class="opacity-50"> - </button>
                            <span id="quantity" class="mx-2 w-12 border-none bg-transparent text-center focus:outline-none">0</span>
                            <button type="button" id="static_plus" class="opacity-50"> + </button>
                        @endif
                    </div>

                    <br>

                    <div style="font-weight: 500; font-size:20px; text-align:center">
                        @if ($stock >= 5)
                            <p style="color: green; background:rgb(108, 249, 131)">In Stock</p>
                        @elseif ($stock > 0)
                            <p style="color: rgb(180, 125, 25); background:rgb(241, 203, 132); padding-right:10px; padding-left:10px">Only {{ $stock }} remaining</p>
                        @else
                            <p style="color: rgb(149, 30, 30); background:rgb(247, 143, 143)">Out of stock</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-4xl font-light tracking-tight sm:text-5xl md:text-6xl">
                &pound;{{ $price }}
            </div>
        </div>
    </div>

    <button type="submit" class="w-full rounded bg-gray-800 px-6 py-3 text-base font-medium text-white shadow-sm transition duration-200 hover:bg-black sm:w-56 sm:text-lg">
        Add to basket
    </button>
</div>

<script>
    const quantityInput = document.getElementById('quantity');
    const plusButton = document.getElementById('plus_quantity');
    const minusButton = document.getElementById('minus_quantity');
    const maximumStock = {{ $stock }};

    if (quantityInput && plusButton && minusButton) {
        plusButton.onclick = () => {
            let currentVal = parseInt(quantityInput.value);
            if (currentVal < maximumStock) {
                quantityInput.value = currentVal + 1;
            }
        };

        minusButton.onclick = () => {
            let currentVal = parseInt(quantityInput.value);
            if (currentVal > 1) {
                quantityInput.value = currentVal - 1;
            }
        };
    }
</script>
