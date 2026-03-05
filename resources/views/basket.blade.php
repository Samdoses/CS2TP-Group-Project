<x-header></x-header>
<x-layout>
    <section class="bg-gray-900 text-gray-100 py-10 md:py-12">
        <main class="container mx-auto max-w-6xl px-4">
            <div class="mb-8 md:mb-10">
                <h1 class="text-center text-4xl font-extrabold text-white">Your Shopping Basket</h1>
                <p class="mt-2 text-center text-sm text-gray-300">Review your items and continue to checkout when ready.</p>
            </div>

            @if (session('error'))
                <div class="mx-auto mb-6 max-w-4xl">
                    <div class="rounded-lg border-l-4 border-red-500 bg-red-800 p-4 text-red-200 shadow-sm" role="alert">
                        <p class="font-bold">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if (!$basket || $basket->items->isEmpty())
                <div class="mx-auto max-w-3xl rounded-2xl border border-gray-700 bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 p-8 text-gray-100 shadow-sm">
                    <div class="mb-4 flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-700 text-xl">🛒</span>
                        <p class="text-2xl font-bold text-gray-100">Your Basket is Empty</p>
                    </div>
                    <p class="mb-6 text-[15px] text-gray-400">Looks like you have not added any components yet. Start shopping to build your setup.</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('store.index') }}" class="rounded-lg bg-indigo-600 px-5 py-3 text-sm font-bold text-white shadow hover:bg-indigo-500 transition">
                            Start Shopping
                        </a>
                        <a href="{{ route('store.index') }}" class="rounded-lg border border-gray-500 bg-gray-800 px-5 py-3 text-sm font-bold text-gray-100 hover:bg-gray-700 transition">
                            Browse Components
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    <div class="space-y-6 lg:col-span-2">
                        @php $total = 0; @endphp

                        @foreach ($basket->items as $item)
                            @php
                                $itemPrice = $item->product->product_price * $item->quantity;
                                $total += $itemPrice;
                            @endphp

                            <div class="flex flex-col items-start gap-6 rounded-xl border border-gray-700 bg-gray-800 p-6 shadow-lg md:flex-row">
                                <div class="shrink-0">
                                    <img src="{{ $item->product->product_image }}" alt="{{ $item->product->product_name }}" class="h-24 w-24 rounded-lg object-cover shadow-sm">
                                </div>

                                <div class="min-w-0 flex-1">
                                    <a href="/product/{{$item->product->id}}" class="mb-1 block truncate text-xl font-bold text-gray-100 transition hover:text-indigo-400">
                                        {{ $item->product->product_name }}
                                    </a>
                                    <p class="mb-3 text-sm text-gray-400">Model: {{ $item->product->product_model }}</p>

                                    <form method="POST" action="{{ route('basket.remove') }}">
                                        @csrf
                                        <input type="hidden" name="basket_item_id" value="{{ $item->id }}">
                                        <button type="submit" class="text-sm font-medium text-red-400 transition hover:text-red-600">
                                            Remove Item
                                        </button>
                                    </form>
                                </div>

                                <div class="flex flex-col items-end gap-2 md:w-40 md:items-center md:gap-4">
                                    <div class="text-lg font-bold text-gray-100">
                                        £{{ number_format($itemPrice, 2) }}
                                    </div>

                                    <div class="flex items-center gap-2 overflow-hidden rounded-lg border border-gray-700">
                                        <form method="POST" action="{{ route('basket.update') }}">
                                            @csrf
                                            <input type="hidden" name="basket_item_id" value="{{ $item->id }}">
                                            <input type="hidden" name="action" value="decrement">
                                            <button type="submit" class="h-full bg-gray-700 px-3 py-1 text-base leading-none transition hover:bg-gray-600">
                                                -
                                            </button>
                                        </form>

                                        <span class="min-w-[30px] text-center font-semibold text-gray-100">
                                            {{ $item->quantity }}
                                        </span>

                                        <form method="POST" action="{{ route('basket.update') }}">
                                            @csrf
                                            <input type="hidden" name="basket_item_id" value="{{ $item->id }}">
                                            <input type="hidden" name="action" value="increment">

                                            @if ($item->quantity >= $item->product->product_stock)
                                                <button disabled class="h-full bg-gray-600 px-3 py-1 text-base leading-none opacity-50">
                                                    +
                                                </button>
                                            @else
                                                <button type="submit" class="h-full bg-gray-700 px-3 py-1 text-base leading-none transition hover:bg-gray-600">
                                                    +
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <aside class="space-y-6 lg:col-span-1">
                        <div class="sticky top-8 rounded-xl border bg-gray-800 p-6 shadow-lg">
                            <h2 class="mb-4 border-b pb-3 text-2xl font-bold text-gray-100">Order Summary</h2>

                            <div class="mb-2 flex justify-between text-gray-300">
                                <span>Subtotal ({{ $basket->items->count() }} items):</span>
                                <span>£{{ number_format($total, 2) }}</span>
                            </div>
                            <div class="mb-4 flex justify-between border-b pb-4 text-gray-300">
                                <span>Shipping:</span>
                                <span class="font-semibold">Calculated</span>
                            </div>

                            <div class="mb-6 flex justify-between text-xl font-extrabold text-gray-100">
                                <span>Order Total:</span>
                                <span>£{{ number_format($total, 2) }}</span>
                            </div>

                            <a href="/checkout" class="block w-full rounded-lg bg-indigo-600 p-3 text-center text-lg font-bold text-white shadow-lg transition duration-200 hover:bg-indigo-700">
                                Go to Checkout
                            </a>
                        </div>

                        <div class="rounded-xl border border-gray-700 bg-gray-800 p-4 shadow-sm">
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <input type="checkbox" id="gift" class="mr-3 h-4 w-4 cursor-pointer accent-indigo-600">
                                    <label for="gift" class="cursor-pointer select-none text-sm text-gray-100">
                                        Buying as a Gift?
                                    </label>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('store.index') }}" class="block w-full rounded-lg border border-gray-700 bg-gray-800 p-3 text-center text-[15px] font-bold text-gray-100 shadow-sm transition-colors duration-200 hover:bg-gray-700">
                            ← Back to Store
                        </a>
                    </aside>
                </div>
            @endif
        </main>
    </section>

</x-layout>
<x-footer></x-footer>
