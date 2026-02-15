<!--Quantity, price. add to basket-->
<div class="purchase-block">
    <hr class="border-black mb-6">

    <div class="mb-4">
        <div class="flex justify-between items-end">

            <div class="flex items-center gap-6 text-4xl font-light select-none">

                <div class="mb-4">
                    <label class="block font-bold text-x1 mb-4">Quantity</label>
                    <div class="flex items-center gap-6 text-4xl font-light select-none">

                        @if($stock != 0)
                        <button type="button" id="minus_quantity"> - </button>
                        <input id="quantity" name="quantity" type="number" value="1" min="1" max="{{$stock}}" class="mx-2 w-12 text-center bg-transparent border-none appearance-none focus:outline-none" />
                        <button type="button" id="plus_quantity"> + </button>
                        @else
                        <button type="button" id="static_minus" class= "opacity-50"> - </button>
                        <span id="quantity" name="quantity" type="number" value="0" class="mx-2 w-12 text-center bg-transparent border-none appearance-none focus:outline-none"> 0 </span>
                        <button type="button" id="static_plus" class= "opacity-50"> + </button>
                        @endif


                    </div>
                    <br>
                    <div style= "font-weight: 500; font-size:20px; text-align:center">
                        @if($stock >= 5)
                            <p style="color: green; background:rgb(108, 249, 131)">In Stock</p>
                        @elseif($stock > 0)
                            <p style="color: rgb(180, 125, 25); background:rgb(241, 203, 132); padding-right:10px; padding-left:10px">Only {{$stock}} remaining</p>
                        @else
                            <p style="color: rgb(149, 30, 30); background:rgb(247, 143, 143)"> Out of stock</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-6xl font-light tracking-tight">
                £{{ $price }}
            </div>
        </div>
    </div>

    <hr class="border-black mb-8">

    <button type="submit" class="w-48 bg-gray-800 text-white py-3 px-6 rounded text-lg font-medium hover:bg-black transition duration-200 shadow-sm">
        Add to basket
    </button>
</div>

<script>
    const quantityInput = document.getElementById('quantity');
    const maximumStock = {{ $stock }};

    document.getElementById('plus_quantity').onclick = () => {
        let currentVal = parseInt(quantityInput.value);
        if (currentVal < maximumStock)
            quantityInput.value = currentVal + 1;
    };

    document.getElementById('minus_quantity').onclick = () => {
        let currentVal = parseInt(quantityInput.value);
        if (currentVal > 1)
            quantityInput.value = currentVal - 1;
    };
</script>

