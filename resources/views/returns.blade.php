<x-header></x-header>
<x-layout>

    <!-- The box for the return-->
    <div class="max-w-2xl mx-auto px-4 py-8 sm:py-12">
        <div class="bg-white p-5 sm:p-8 md:p-12 rounded-xl border border-gray-100 shadow-2x1 items-center">
            <!-- Title -->
            <h2 class= "text-center text-2xl md:text-3xl font-bold text-gray-800 mt-2 sm:mt-4 mb-4"> Returns Request</h2>
            <!-- return message -->
            <p class="text-gray-600 mb-8 text-center"> You can return items within 30 days of purchase. Please fill out the form and submit your return request.</p>

            <p class="mb-4 text-gray-700"> <strong> Order #{{ $order->id }} </strong></p>

            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg mb-8 border border-gray-200">
                <img src="{{ $product->product_image }}" class="w-16 h-16 object-cover rounded shadow-sm">
                <div>
                    <h3 class="font-bold text-gray-800">{{ $product->product_name }}</h3>
                    <p class="text-xs text-gray-500">Model: {{ $product->product_model }}</p>
                    <p class="text-xs text-gray-500">Colour: {{ $product->product_colour}}</p>
                </div>
            </div>

            <form action="{{ route('orders.return.process', [$order->id, $product->id]) }}" method="POST">
                @csrf

            <div class="mb-6">
                <label class="block mb-2 font-bold text-gray-700">Quantity to Return</label>
                <select name="return_quantity" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 outline-none">
                    @for ($i = 1; $i <= $maxQuantity; $i++)
                         <option value="{{ $i }}">{{ $i }} unit(s)</option>
                    @endfor
                </select>
            </div>
            <label class="block mb-4 font-bold text-gray-700"> Reason for Return </label>
            <!-- select the option for return -->
            <select name="reason" class="w-full border rounded-lg p-3 mb-4" required>
                <option disabled selected> Select an option </option>
                <option> Wrong item received </option>
                <option> Wrong size/fit </option>
                <option> Defective Product </option>
                <option> Item not as described </option>
                <option> Changed my mind </option>
                <option> Other </option>
            </select>
            <!-- the additional details -->
            <label class="block mb-4 font-medium"> Additional details </label>
            <textarea name="additional_details" rows="4" class="w-full border rounded-lg p-3 mb-4"></textarea>
            <!-- the submit button -->
            <div class="flex flex-col gap-3">
                <button class="block w-full rounded-lg bg-indigo-600 p-3 text-center text-lg font-bold text-white shadow-lg transition duration-200 hover:bg-indigo-700">
                    Submit Your Request
                </button>
                <a href="{{ route('profile.orders.show', $order->id) }}" class="text-center text-gray-500 hover:text-gray-700 text-sm font-semibold">Cancel and Go Back</a>
            </div>
        </div>
    </div>
</x-layout>
<x-footer></x-footer>
