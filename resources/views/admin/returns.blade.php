<x-admin-layout title="Admin Returns">
    <section class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        @include('admin.partials.alerts')

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Returns Queue</p>
                    <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Customer Returns</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Review return requests, approve or reject them, and leave an optional comment for the customer.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach (['processing' => 'Processing', 'approved' => 'Approved', 'rejected' => 'Rejected', 'refunded' => 'Refunded', 'all' => 'All'] as $value => $label)
                        <a href="{{ route('admin.returns.index', ['filter' => $value]) }}"
                           class="rounded-full px-4 py-2 text-sm font-medium transition {{ $filter === $value ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-white/10 dark:text-gray-300 dark:hover:bg-white/20' }}">
                            {{ $label }}
                            <span class="ml-1 text-xs opacity-75">{{ $returnStats[$value] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="space-y-4">
            @forelse ($returns as $return)
                <article class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $return->product->product_name ?? 'Product unavailable' }}</h2>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $return->return_status === 'Processing' ? 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-200' : ($return->return_status === 'Approved' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-200' : ($return->return_status === 'Refunded' ? 'bg-sky-100 text-sky-700 dark:bg-sky-500/10 dark:text-sky-200' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-200')) }}">
                                    {{ $return->return_status }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Order #{{ $return->order_id }} · {{ $return->user->first_name ?? 'Customer' }} {{ $return->user->last_name ?? '' }} · Quantity {{ $return->return_quantity }}
                            </p>
                            <div class="mt-4 rounded-2xl bg-gray-50 p-4 text-sm leading-7 text-gray-700 dark:bg-slate-950/60 dark:text-gray-300">
                                <p><span class="font-semibold">Reason:</span> {{ $return->reason }}</p>
                                @if ($return->admin_comment)
                                    <p class="mt-3"><span class="font-semibold">Admin comment:</span> {{ $return->admin_comment }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="w-full max-w-md">
                            @if ($return->return_status === 'Processing')
                                <form method="POST" action="{{ route('admin.returns.update', $return) }}" class="space-y-3">
                                    @csrf
                                    @method('PATCH')
                                    <div>
                                        <label for="admin_comment_{{ $return->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Optional comment</label>
                                        <textarea id="admin_comment_{{ $return->id }}" name="admin_comment" rows="4" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white" placeholder="Add context for the customer if needed.">{{ old('admin_comment') }}</textarea>
                                    </div>
                                    <div class="flex flex-wrap gap-3">
                                        <button type="submit" name="return_status" value="Approved" class="rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">Approve return</button>
                                        <button type="submit" name="return_status" value="Rejected" class="rounded-2xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-700">Reject return</button>
                                    </div>
                                </form>
                            @else
                                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-600 dark:border-gray-700 dark:bg-slate-950/60 dark:text-gray-300">
                                    Processed {{ optional($return->admin_processed_at)->format('d M Y H:i') ?? 'recently' }}.
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <p class="rounded-3xl border border-gray-200 bg-white px-6 py-8 text-sm text-gray-500 shadow-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400">No returns matched this filter.</p>
            @endforelse

            <div>{{ $returns->links() }}</div>
        </section>
    </section>
</x-admin-layout>
