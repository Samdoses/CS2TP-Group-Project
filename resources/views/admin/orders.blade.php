<x-admin-layout title="Admin Orders">
    <section class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        @include('admin.partials.alerts')

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Order Queue</p>
                    <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Orders</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Review placed orders and update the order status customers see in their account.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach (['open' => 'Open', 'delivered' => 'Delivered', 'refunded' => 'Refunded', 'all' => 'All'] as $value => $label)
                        <a href="{{ route('admin.orders.index', ['filter' => $value]) }}"
                           class="rounded-full px-4 py-2 text-sm font-medium transition {{ $filter === $value ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-white/10 dark:text-gray-300 dark:hover:bg-white/20' }}">
                            {{ $label }}
                            <span class="ml-1 text-xs opacity-75">{{ $orderStats[$value] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="space-y-4">
            @forelse ($orders as $order)
                <article class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Order #{{ $order->id }}</h2>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->getColourStatus() }}">
                                    {{ $order->order_status }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ $order->user->first_name ?? 'Customer' }} {{ $order->user->last_name ?? '' }}
                                · {{ $order->user->email ?? 'No email' }}
                                · {{ optional($order->order_date)->format('d M Y H:i') }}
                            </p>

                            <div class="mt-4 rounded-2xl bg-gray-50 p-4 text-sm text-gray-700 dark:bg-slate-950/60 dark:text-gray-300">
                                <p><span class="font-semibold">Address:</span> {{ $order->order_address }}</p>
                                <p class="mt-2"><span class="font-semibold">Delivery method:</span> {{ ucfirst($order->delivery_method) }}</p>
                                <p class="mt-2"><span class="font-semibold">Total:</span> &pound;{{ number_format($order->total_price, 2) }}</p>
                            </div>

                            <div class="mt-4 overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-200 text-left text-gray-500 dark:border-gray-800 dark:text-gray-400">
                                            <th class="py-2 pr-4">Product</th>
                                            <th class="py-2 pr-4">Qty</th>
                                            <th class="py-2 pr-4">Delivery Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderDetails as $item)
                                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                                <td class="py-3 pr-4 text-gray-900 dark:text-white">{{ $item->product->product_name ?? 'Removed product' }}</td>
                                                <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ $item->quantity }}</td>
                                                <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ $item->delivery_status ?? 'Pending' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="w-full max-w-xs">
                            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-3">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label for="order_status_{{ $order->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order status</label>
                                    <select id="order_status_{{ $order->id }}" name="order_status" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                                        @foreach ($orderStatuses as $status)
                                            <option value="{{ $status }}" @selected($order->order_status === $status)>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="w-full rounded-2xl bg-gray-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                                    Save Order Status
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <p class="rounded-3xl border border-gray-200 bg-white px-6 py-8 text-sm text-gray-500 shadow-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400">No orders matched this filter.</p>
            @endforelse

            <div>{{ $orders->links() }}</div>
        </section>
    </section>
</x-admin-layout>
