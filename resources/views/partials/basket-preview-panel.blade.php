@php
    $basketItems = $basketPreview?->items ?? collect();
    $basketPreviewItems = $basketItems->take(4);
@endphp

<div class="flex items-center justify-between gap-3 border-b border-gray-200 pb-3 dark:border-gray-800">
    <div>
        <h3 class="text-sm font-semibold">Your Basket</h3>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $basketCount }} item{{ $basketCount === 1 ? '' : 's' }}</p>
    </div>
    <a href="{{ route('basket.view') }}" class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-800 dark:text-indigo-300 dark:hover:text-indigo-200">
        Open Basket
    </a>
</div>

@if ($basketPreviewItems->isEmpty())
    <div class="py-6 text-center">
        <p class="text-sm text-gray-500 dark:text-gray-400">Your basket is empty.</p>
        <a href="{{ route('store.index') }}" class="mt-4 inline-flex rounded-full bg-gray-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
            Shop now
        </a>
    </div>
@else
    <div class="mt-4 max-h-[24rem] space-y-3 overflow-y-auto pr-1">
        @foreach ($basketPreviewItems as $item)
            <article class="rounded-2xl border border-gray-200 p-3 dark:border-gray-800">
                <div class="flex items-start gap-3">
                    <a href="{{ route('product.show', $item->product->id) }}" class="shrink-0">
                        <img src="{{ $item->product->product_image }}" alt="{{ $item->product->product_name }}" class="h-16 w-16 rounded-xl object-cover">
                    </a>

                    <div class="min-w-0 flex-1">
                        <a href="{{ route('product.show', $item->product->id) }}" class="block truncate text-sm font-semibold text-gray-900 transition hover:text-indigo-600 dark:text-white dark:hover:text-indigo-300">
                            {{ $item->product->product_name }}
                        </a>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $item->product->product_model ?: 'No model listed' }}</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">&pound;{{ number_format($item->product->product_price * $item->quantity, 2) }}</p>

                        <div class="mt-3 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2 overflow-hidden rounded-lg border border-gray-300 dark:border-gray-700">
                                <form method="POST" action="{{ route('basket.update') }}" data-basket-async="true">
                                    @csrf
                                    <input type="hidden" name="basket_item_id" value="{{ $item->id }}">
                                    <input type="hidden" name="action" value="decrement">
                                    <button type="submit" class="bg-gray-50 px-3 py-1 text-sm transition hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700">-</button>
                                </form>

                                <span class="min-w-[26px] text-center text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $item->quantity }}</span>

                                <form method="POST" action="{{ route('basket.update') }}" data-basket-async="true">
                                    @csrf
                                    <input type="hidden" name="basket_item_id" value="{{ $item->id }}">
                                    <input type="hidden" name="action" value="increment">
                                    <button type="submit" @disabled($item->quantity >= $item->product->product_stock) class="bg-gray-50 px-3 py-1 text-sm transition hover:bg-gray-200 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-gray-800 dark:hover:bg-gray-700">+</button>
                                </form>
                            </div>

                            <form method="POST" action="{{ route('basket.remove') }}" data-basket-async="true">
                                @csrf
                                <input type="hidden" name="basket_item_id" value="{{ $item->id }}">
                                <button type="submit" class="text-xs font-semibold text-red-500 transition hover:text-red-700 dark:text-red-300 dark:hover:text-red-200">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    @if ($basketItems->count() > $basketPreviewItems->count())
        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
            Showing {{ $basketPreviewItems->count() }} of {{ $basketItems->count() }} basket items.
        </p>
    @endif

    <div class="mt-4 border-t border-gray-200 pt-4 dark:border-gray-800">
        <div class="flex items-center justify-between text-sm font-semibold">
            <span class="text-gray-600 dark:text-gray-300">Subtotal</span>
            <span class="text-gray-900 dark:text-white">&pound;{{ number_format($basketSubtotal, 2) }}</span>
        </div>

        <div class="mt-4 flex gap-3">
            <a href="{{ route('basket.view') }}" class="flex-1 rounded-full border border-gray-300 px-4 py-2 text-center text-sm font-semibold text-gray-700 transition hover:bg-gray-100 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-white/5">
                Manage Basket
            </a>
            <a href="{{ route('checkout.index') }}" class="flex-1 rounded-full bg-gray-900 px-4 py-2 text-center text-sm font-semibold text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                Checkout
            </a>
        </div>
    </div>
@endif
