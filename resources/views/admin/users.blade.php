<x-admin-layout title="Admin Users">
    <section class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        @include('admin.partials.alerts')

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Users and Orders</p>
                    <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Customer History</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Inspect registered users, review their orders, and update delivery status for each ordered item.</p>
                </div>
                <span class="rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-700 dark:bg-white/10 dark:text-gray-300">{{ $users->total() }} users</span>
            </div>
        </section>

        <section class="space-y-6">
            @forelse ($users as $user)
                <article class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <details id="user-{{ $user->id }}" class="group">
                        <summary class="list-none cursor-pointer">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->first_name }} {{ $user->last_name }}</h2>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-white/10 dark:text-gray-300">{{ $user->orders->count() }} orders</span>
                                    <span class="text-gray-400 transition group-open:rotate-180">
                                        <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                            <path d="M6 9l6 6 6-6"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </summary>

                        @if ($user->orders->isEmpty())
                            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">No orders yet.</p>
                        @else
                            <div class="mt-4 space-y-4">
                                @foreach ($user->orders as $order)
                                    <details class="group rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-slate-950/60">
                                        <summary class="list-none cursor-pointer">
                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-700 dark:text-gray-300">
                                                <span class="font-semibold text-gray-900 dark:text-white">Order #{{ $order->id }}</span>
                                                <span>Total: &pound;{{ number_format($order->total_price, 2) }}</span>
                                                <span>Method: {{ ucfirst($order->delivery_method) }}</span>
                                                <span>Date: {{ optional($order->order_date)->format('d M Y H:i') }}</span>
                                                <span class="rounded-md bg-blue-100 px-2 py-0.5 text-xs font-bold {{ $order->getColourStatus() }}">
                                                    {{ $order->order_status ?? 'Processing' }}
                                                </span>

                                                <span class="text-gray-400 transition group-open:rotate-180">
                                                    <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                                        <path d="M6 9l6 6 6-6"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </summary>

                                        <div class="flex items-center justify-between border-gray-200 pb-4 dark:border-gray-800">
                                            <h4 class="font-medium text-gray-900 dark:text-white">Update Order Status</h4>
                                            <form method="POST" action="{{ route('admin.order.order-status', $order) }}" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="rounded-xl border border-gray-300 px-3 py-1.5 text-xs dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                                                    @foreach ($orderDeliveryStatuses as $status)
                                                        <option value="{{ $status }}" @selected(($order->order_status ?? 'Pending') === $status)>{{ $status }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="rounded-full bg-gray-900 px-4 py-1.5 text-xs font-medium text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900">
                                                    Update Order
                                                </button>
                                            </form>
                                        </div>

                                        <div class="mt-4 overflow-x-auto">
                                            <table class="min-w-full text-sm">
                                                <thead>
                                                    <tr class="border-b border-gray-200 text-left text-gray-500 dark:border-gray-800 dark:text-gray-400">
                                                        <th class="py-2 pr-4">Product</th>
                                                        <th class="py-2 pr-4">Qty</th>
                                                        <th class="py-2 pr-4">Item Price</th>
                                                        <th class="py-2 pr-4">Delivery Status</th>
                                                        <th class="py-2 pr-4">Update</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderDetails as $item)
                                                        @php $currentStatus = $item->delivery_status ?? 'Pending'; @endphp
                                                        <tr class="border-b border-gray-100 dark:border-gray-800">
                                                            <td class="py-3 pr-4 text-gray-900 dark:text-white">{{ $item->product->product_name ?? 'Removed product' }}</td>
                                                            <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ $item->quantity }}</td>
                                                            <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">&pound;{{ number_format($item->order_price, 2) }}</td>
                                                            <td class="py-3 pr-4 font-medium text-gray-800 dark:text-gray-200">{{ $currentStatus }}</td>
                                                            <td class="py-3 pr-4">
                                                            <!--only display selection of changing the item status if its pending return or being returned-->
                                                            @php
                                                                $isReturnStatus = in_array($currentStatus, ['Pending Return', 'Returned']);
                                                                $hasRequest = $item->hasReturnRequest();
                                                            @endphp

                                                            @if($hasRequest || $isReturnStatus)
                                                                <!-- show the form only if a request exists or if it's already pending/has been returned -->
                                                                <form method="POST" action="{{ route('admin.order-items.delivery-status', $item) }}" class="flex flex-wrap items-center gap-2">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <select name="delivery_status" class="rounded-xl border border-gray-300 px-2 py-1 text-xs dark:border-gray-700 dark:bg-slate-950 dark:text-white">
                                                                        @foreach ($deliveryStatuses as $statusOption)
                                                                            <!-- check if the request exists and if it does show the option to change its item status -->
                                                                            @if(!in_array($statusOption, ['Pending Return', 'Returned']) || $hasRequest)
                                                                                <option value="{{ $statusOption }}" @selected($currentStatus === $statusOption)>
                                                                                    {{ $statusOption }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <button type="submit" class="rounded-full bg-gray-900 px-3 py-1 text-xs font-medium text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900">
                                                                        Save
                                                                    </button>
                                                                </form>
                                                            @else
                                                                {{-- Show a simple span if no return request exists yet --}}
                                                                <span class="text-xs font-medium text-gray-400 italic">
                                                                    No return request
                                                                </span>
                                                            @endif
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </details>
                                @endforeach
                            </div>
                        @endif
                    </details>
                </article>
            @empty
                <p class="rounded-3xl border border-gray-200 bg-white px-6 py-8 text-sm text-gray-500 shadow-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400">No registered users found.</p>
            @endforelse

            <div>{{ $users->links() }}</div>
        </section>
    </section>
</x-admin-layout>
