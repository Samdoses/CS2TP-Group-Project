<!--Quantity, price. add to basket-->
<div class="purchase-block">
    <hr class="border-black mb-6">
    
    <div class="mb-4">
        <label for="quantity" class="block font-bold text-xl mb-4">Quantity</label>
        <div class="flex justify-between items-end">
            
            <div class="flex items-center gap-6 text-4xl font-light select-none">
                <button aria-label="Decrease quantity" class="hover:text-gray-600 pb-1 cursor-pointer">−</button>
                <input id="quantity" type="number" value={{ $quantity }} class="mx-2 w-12 text-center bg-transparent border-none appearance-none focus:outline-none" readonly />
                <button aria-label="Increase quantity" class="hover:text-gray-600 pb-1 cursor-pointer">+</button>
            </div>

            <div class="text-6xl font-light tracking-tight">
                £{{ $price }}
            </div>
        </div>
    </div>

    <hr class="border-black mb-8">

    <button class="w-48 bg-gray-800 text-white py-3 px-6 rounded text-lg font-medium hover:bg-black transition duration-200 shadow-sm">
        Add to basket
    </button>
</div>