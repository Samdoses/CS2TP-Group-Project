<x-admin-layout title="Admin Overview">
    <section class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        @include('admin.partials.alerts')

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Admin Overview</p>
                    <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Performance Snapshot</h1>
                    <p class="mt-2 max-w-3xl text-sm text-gray-600 dark:text-gray-300">Track order activity, sales, signups, basket demand, and incoming customer messages from one dashboard.</p>
                </div>
                <div class="rounded-2xl bg-gray-50 px-4 py-3 text-sm text-gray-600 dark:bg-white/5 dark:text-gray-300">
                    Total registered users: <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($totalUsers) }}</span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-slate-950/60">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Orders in Past Hour</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $ordersPastHour }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-slate-950/60">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Orders in Past Week</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $ordersPastWeek }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-slate-950/60">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Orders in Past Month</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $ordersPastMonth }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-slate-950/60">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Sales</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">&pound;{{ number_format($totalSales, 2) }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-slate-950/60">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Average Order Value</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">&pound;{{ number_format($averageOrderValue, 2) }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-slate-950/60">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Open Delivery Items</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $openDeliveryItems }}</p>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Pending, packed, shipped, and out-for-delivery items.</p>
                </div>
                <a href="{{ route('admin.reviews.index') }}" class="rounded-2xl border border-gray-200 bg-gray-50 p-4 transition hover:border-gray-300 hover:bg-white dark:border-gray-800 dark:bg-slate-950/60 dark:hover:border-gray-700 dark:hover:bg-slate-900">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pending Website Reviews</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $pendingWebsiteReviews }}</p>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Customer website reviews waiting for approval.</p>
                </a>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-8 xl:grid-cols-2">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Sales in the Last 7 Days</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Daily sales trend based on completed order totals.</p>
                    </div>
                </div>
                <div class="mt-6 h-80">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">User Signups</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Registered users grouped by month.</p>
                <div class="mt-6 h-80">
                    <canvas id="signupChart"></canvas>
                </div>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Top Selling Products</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Products ranked by ordered quantity.</p>
                <div class="mt-6 h-80">
                    <canvas id="topProductsChart"></canvas>
                </div>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Order Status Breakdown</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Current order pipeline distribution.</p>
                <div class="mt-6 h-80">
                    <canvas id="orderStatusChart"></canvas>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-8 xl:grid-cols-3">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 xl:col-span-2">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Items in Baskets Right Now</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Live basket popularity based on current basket quantities.</p>
                    </div>
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-white/10 dark:text-gray-300">Top 8</span>
                </div>

                @if (collect($basketChart['items'])->isEmpty())
                    <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">No items are currently in any basket.</p>
                @else
                    <div class="mt-6 h-80">
                        <canvas id="basketChart"></canvas>
                    </div>
                @endif
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Recent Messages</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Latest contact-us submissions.</p>
                    </div>
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-white/10 dark:text-gray-300">{{ $totalMessages }}</span>
                </div>

                <div class="mt-6 space-y-4">
                    @forelse ($recentMessages as $message)
                        <article class="rounded-2xl border border-gray-200 p-4 dark:border-gray-800">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $message->subject }}</p>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $message->sender_name ?: ($message->user ? $message->user->first_name . ' ' . $message->user->last_name : 'Unknown sender') }}
                                        @if ($message->sender_email)
                                            · {{ $message->sender_email }}
                                        @endif
                                    </p>
                                </div>
                                <span class="text-xs text-gray-400">{{ optional($message->created_at)->format('d M H:i') }}</span>
                            </div>
                            <p class="mt-3 line-clamp-4 text-sm text-gray-600 dark:text-gray-300">{{ $message->message }}</p>
                        </article>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No contact messages yet.</p>
                    @endforelse
                </div>

                <a href="{{ route('admin.messages.index') }}" class="mt-6 inline-flex rounded-full border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-white/20 dark:text-gray-300 dark:hover:bg-white/10">View All Messages</a>
            </div>
        </section>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function () {
                const chartText = document.documentElement.classList.contains('dark') ? '#e5e7eb' : '#374151';
                const gridColor = document.documentElement.classList.contains('dark') ? 'rgba(148, 163, 184, 0.2)' : 'rgba(148, 163, 184, 0.25)';

                const buildBarChart = function (id, labels, values, color) {
                    const canvas = document.getElementById(id);
                    if (!canvas) return;
                    new Chart(canvas, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: color,
                                borderRadius: 8,
                                borderSkipped: false,
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { ticks: { color: chartText }, grid: { display: false } },
                                y: { beginAtZero: true, ticks: { color: chartText, precision: 0 }, grid: { color: gridColor } },
                            },
                        },
                    });
                };

                const salesCanvas = document.getElementById('salesChart');
                if (salesCanvas) {
                    new Chart(salesCanvas, {
                        type: 'line',
                        data: {
                            labels: @json($salesChart['labels']),
                            datasets: [{
                                label: 'Sales',
                                data: @json($salesChart['values']),
                                fill: true,
                                tension: 0.35,
                                borderColor: '#111827',
                                backgroundColor: 'rgba(17, 24, 39, 0.12)',
                                pointBackgroundColor: '#111827',
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                x: { ticks: { color: chartText }, grid: { display: false } },
                                y: { beginAtZero: true, ticks: { color: chartText }, grid: { color: gridColor } },
                            },
                        },
                    });
                }

                buildBarChart('signupChart', @json($signupChart['labels']), @json($signupChart['values']), 'rgba(59, 130, 246, 0.75)');
                buildBarChart('topProductsChart', @json($topProductsChart['labels']), @json($topProductsChart['values']), 'rgba(16, 185, 129, 0.75)');
                buildBarChart('basketChart', @json($basketChart['labels']), @json($basketChart['values']), 'rgba(168, 85, 247, 0.75)');

                const orderStatusCanvas = document.getElementById('orderStatusChart');
                if (orderStatusCanvas) {
                    new Chart(orderStatusCanvas, {
                        type: 'doughnut',
                        data: {
                            labels: @json($orderStatusChart['labels']),
                            datasets: [{
                                data: @json($orderStatusChart['values']),
                                backgroundColor: ['#111827', '#2563eb', '#16a34a', '#f59e0b', '#dc2626', '#8b5cf6', '#06b6d4'],
                                borderWidth: 0,
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: { color: chartText },
                                },
                            },
                        },
                    });
                }
            })();
        </script>
    @endpush
</x-admin-layout>

