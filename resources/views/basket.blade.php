<x-header></x-header>
<x-layout>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <nav class="w-full bg-white shadow-md p-4 mb-8 text-center border-b border-gray-200">
        </nav>

    <main class="flex-grow container mx-auto px-4 max-w-6xl">
        
        <h1 class="text-4xl font-extrabold text-gray-800 mb-8 text-center">
            Your Shopping Basket
        </h1>

        @if (!$basket || $basket->items->isEmpty())
            <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg shadow-inner" role="alert">
                <p class="font-bold text-xl mb-2">Your Basket is Empty!</p>
                <p>Click <a href="{{ route('store.index') }}" class="font-semibold underline hover:text-blue-900 transition">here</a> to add components from the store.</p>
            </div>
        @else

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">
                    @php $total = 0; @endphp
                    
                    @foreach ($basket->items as $item)
                        @php 
                            $itemPrice = $item->product->product_price * $item->quantity;
                            $total += $itemPrice;
                        @endphp

                        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col md:flex-row items-start gap-6 border border-gray-200">
                            
                            <div class="flex-shrink-0">
                                <img src="{{ $item->product->product_image }}" alt="{{ $item->product->product_name }}" 
                                     class="w-24 h-24 object-cover rounded-lg shadow-sm">
                            </div>

                            <div class="flex-1 min-w-0">
                                <a href="#" class="text-xl font-bold text-gray-800 hover:text-blue-600 transition truncate block mb-1">
                                    {{ $item->product->product_name }}
                                </a>
                                <p class="text-sm text-gray-500 mb-3">Model: {{ $item->product->product_model }}</p>
                                
                                <form method="POST" action="{{ route('basket.remove') }}">
                                    @csrf
                                    <input type="hidden" name="basket_item_id" value="{{ $item->id }}">
                                    
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium transition">
                                        Remove Item
                                    </button>
                                </form>
                            </div>

                            <div class="flex flex-col items-end md:items-center gap-2 md:gap-4 md:w-40">
                                <div class="font-bold text-lg text-gray-800">
                                    £{{ number_format($itemPrice, 2) }}
                                </div>
                                
                                <div class="flex items-center gap-2 border border-gray-300 rounded-lg overflow-hidden">
                                    
                                    <form method="POST" action="{{ route('basket.update') }}">
                                        @csrf
                                        <input type="hidden" name="basket_item_id" value="{{ $item->id }}">
                                        <input type="hidden" name="action" value="decrement">
                                        <button type="submit" class="px-3 py-1 text-base bg-gray-50 hover:bg-gray-200 transition leading-none h-full">
                                            -
                                        </button>
                                    </form>

                                    <span class="min-w-[30px] text-center font-semibold text-gray-700">
                                        {{ $item->quantity }}
                                    </span>

                                    <form method="POST" action="{{ route('basket.update') }}">
                                        @csrf
                                        <input type="hidden" name="basket_item_id" value="{{ $item->id }}">
                                        <input type="hidden" name="action" value="increment">
                                        <button type="submit" class="px-3 py-1 text-base bg-gray-50 hover:bg-gray-200 transition leading-none h-full">
                                            +
                                        </button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <aside class="lg:col-span-1 space-y-6">
                    
                    <div class="bg-white p-6 border rounded-xl shadow-lg sticky top-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-3">Order Summary</h2>
                        
                        <div class="flex justify-between text-gray-600 mb-2">
                            <span>Subtotal ({{ $basket->items->count() }} items):</span>
                            <span>£{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 mb-4 border-b pb-4">
                            <span>Shipping:</span>
                            <span class="font-semibold">Calculated</span>
                        </div>
                        
                        <div class="flex justify-between text-xl font-extrabold text-gray-800 mb-6">
                            <span>Order Total:</span>
                            <span>£{{ number_format($total, 2) }}</span>
                        </div>
                        
                        <a href="/checkout" 
                           class="block w-full text-center bg-indigo-600 text-white text-lg p-3 rounded-lg shadow-lg hover:bg-indigo-700 transition duration-200 font-bold">
                            Go to Checkout
                        </a>
                    </div>
                    
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="checkbox" id="gift" class="w-4 h-4 mr-3 cursor-pointer accent-indigo-600">
                                <label for="gift" class="text-gray-800 cursor-pointer select-none text-sm">
                                     Buying as a Gift?
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" id="subscribe" class="w-4 h-4 mr-3 cursor-pointer accent-indigo-600">
                                <label for="subscribe" class="text-gray-800 cursor-pointer select-none text-sm">
                                     Stay updated with our offers! Subscribe to our newsletter?
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('store.index') }}" 
                       class="block w-full text-center bg-white text-gray-700 text-[15px] p-3 rounded-lg shadow-sm hover:bg-gray-200 transition-colors duration-200 font-bold border border-gray-300">
                        ← Back to Store
                    </a>

                </aside>
            </div>
        @endif

    </main>
</body>

</x-layout>
<x-footer></x-footer>