<x-header></x-header>
<x-layout>
    <section class="bg-gray-100 py-10 transition-colors duration-300 dark:bg-gray-950 md:py-12">
        <main class="container mx-auto max-w-6xl px-4">
            <div class="mb-8 md:mb-10">
                <h1 class="text-center text-3xl sm:text-4xl font-extrabold text-gray-800 dark:text-white">Your Shopping Basket</h1>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-300">Review your items and continue to checkout when ready.</p>
            </div>

            @if (session('error'))
                <div class="mx-auto mb-6 max-w-4xl">
                    <div class="rounded-lg border-l-4 border-red-500 bg-red-100 p-4 text-red-700 shadow-sm dark:bg-red-900/40 dark:text-red-200" role="alert">
                        <p class="font-bold">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if (!$basket || $basket->items->isEmpty())
                <div class="mx-auto max-w-3xl rounded-2xl border border-gray-300 bg-gradient-to-br from-gray-100 via-gray-200 to-gray-100 p-8 text-gray-800 shadow-sm transition-colors duration-300 dark:border-gray-700 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 dark:text-gray-100">
                    <div class="mb-4 flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-300 text-xl dark:bg-gray-700">🛒</span>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">Your Basket is Empty</p>
                    </div>
                    <p class="mb-6 text-[15px] text-gray-700 dark:text-gray-300">Looks like you have not added any components yet. Start shopping to build your setup.</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('store.index') }}" class="rounded-lg bg-gray-900 px-5 py-3 text-sm font-bold text-white shadow transition hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                            Start Shopping
                        </a>
                        <a href="{{ route('store.index') }}" class="rounded-lg border border-gray-400 bg-white px-5 py-3 text-sm font-bold text-gray-800 transition hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
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

                            <div class="flex flex-col items-start gap-5 rounded-xl border border-gray-200 bg-white p-4 sm:p-6 shadow-lg transition-colors duration-300 dark:border-gray-700 dark:bg-gray-800 md:flex-row">
                                <div class="shrink-0">
                                    <img src="{{ $item->product->product_image }}" alt="{{ $item->product->product_name }}" class="h-24 w-24 rounded-lg object-cover shadow-sm">
                                </div>

                                <div class="min-w-0 flex-1">
                                    <a href="/product/{{$item->product->id}}" class="mb-1 block truncate text-xl font-bold text-gray-800 transition hover:text-blue-600 dark:text-gray-100 dark:hover:text-indigo-400">
                                        {{ $item->product->product_name }}
                                    </a>
                                    <p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Model: {{ $item->product->product_model }}</p>

                                    <form method="POST" action="{{ route('basket.remove') }}">
                                        @csrf
                                        <input type="hidden" name="basket_item_id" value="{{ $item->id }}">
                                        <button type="submit" class="text-sm font-medium text-red-500 transition hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                            Remove Item
                                        </button>
                                    </form>
                                </div>

                                <div class="w-full md:w-40 flex flex-row md:flex-col items-center md:items-center justify-between gap-3 md:gap-4">
                                    <div class="text-lg font-bold text-gray-800 dark:text-gray-100">
                                        £{{ number_format($itemPrice, 2) }}
                                    </div>

                                    <div class="flex items-center gap-2 overflow-hidden rounded-lg border border-gray-300 dark:border-gray-700">
                                        <form method="POST" action="{{ route('basket.update') }}">
                                            @csrf
                                            <input type="hidden" name="basket_item_id" value="{{ $item->id }}">
                                            <input type="hidden" name="action" value="decrement">
                                            <button type="submit" class="h-full bg-gray-50 px-3 py-1 text-base leading-none transition hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600">
                                                -
                                            </button>
                                        </form>

                                        <span class="min-w-[30px] text-center font-semibold text-gray-700 dark:text-gray-100">
                                            {{ $item->quantity }}
                                        </span>

                                        <form method="POST" action="{{ route('basket.update') }}">
                                            @csrf
                                            <input type="hidden" name="basket_item_id" value="{{ $item->id }}">
                                            <input type="hidden" name="action" value="increment">

                                            @if ($item->quantity >= $item->product->product_stock)
                                                <button disabled class="h-full bg-gray-200 px-3 py-1 text-base leading-none opacity-50 dark:bg-gray-600">
                                                    +
                                                </button>
                                            @else
                                                <button type="submit" class="h-full bg-gray-50 px-3 py-1 text-base leading-none transition hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600">
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
                        <div class="rounded-xl lg:sticky lg:top-8 border border-gray-200 bg-white p-5 sm:p-6 shadow-lg transition-colors duration-300 dark:border-gray-700 dark:bg-gray-800">
                            <h2 class="mb-4 border-b border-gray-200 pb-3 text-2xl font-bold text-gray-800 dark:border-gray-700 dark:text-gray-100">Order Summary</h2>

                            <div class="mb-2 flex justify-between text-gray-600 dark:text-gray-300">
                                <span>Subtotal ({{ $basket->items->count() }} items):</span>
                                <span>£{{ number_format($total, 2) }}</span>
                            </div>
                            <div class="mb-4 flex justify-between border-b border-gray-200 pb-4 text-gray-600 dark:border-gray-700 dark:text-gray-300">
                                <span>Shipping:</span>
                                <span class="font-semibold">Calculated</span>
                            </div>

                            <div class="mb-6 flex justify-between text-xl font-extrabold text-gray-800 dark:text-gray-100">
                                <span>Order Total:</span>
                                <span>£{{ number_format($total, 2) }}</span>
                            </div>

                            <a href="/checkout" class="block w-full rounded-lg bg-indigo-600 p-3 text-center text-lg font-bold text-white shadow-lg transition duration-200 hover:bg-indigo-700">
                                Go to Checkout
                            </a>
                        </div>

                        <a href="{{ route('store.index') }}" class="block w-full rounded-lg border border-gray-300 bg-white p-3 text-center text-[15px] font-bold text-gray-700 shadow-sm transition-colors duration-200 hover:bg-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700">
                            ← Back to Store
                        </a>
                    </aside>
                </div>
            @endif
        </main>
    </section>

</x-layout>
<x-footer></x-footer>
