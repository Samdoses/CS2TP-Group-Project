<!--Quantity, price. add to basket-->
<div class="purchase-block">
    <hr class="border-black mb-6">

    <div class="mb-4">
        <div class="flex justify-between items-end">

            <div class="flex items-center gap-6 text-4xl font-light select-none">

                <div class="mb-4">
                    <label class="block font-bold text-x1 mb-4">Quantity</label>
                    <div class="flex items-center gap-6 text-4xl font-light select-none">
                        <button type="button" id="minus_quantity" class= "hover:text-gray-600 pb-1 cursor-pointer"> - </button>
                        <input id="quantity" name="quantity" type="number" value="1" min="1" class="mx-2 w-12 text-center bg-transparent border-none appearance-none focus:outline-none" />
                        <button type="button" id="plus_quantity" class= "hover:text-gray-600 pb-1 cursor-pointer"> + </button>

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
