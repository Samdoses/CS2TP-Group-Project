<x-admin-layout title="Admin Reviews">
    <section class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        @include('admin.partials.alerts')

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Moderation</p>
                    <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Website Reviews</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Approve or reject customer reviews for the website homepage. Pending reviews are the main to-do here.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'all' => 'All'] as $value => $label)
                        <a href="{{ route('admin.reviews.index', ['filter' => $value]) }}"
                           class="rounded-full px-4 py-2 text-sm font-medium transition {{ $filter === $value ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-white/10 dark:text-gray-300 dark:hover:bg-white/20' }}">
                            {{ $label }}
                            <span class="ml-1 text-xs opacity-75">{{ $reviewStats[$value] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="space-y-4">
            @forelse ($reviews as $review)
                <article class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ $review->user?->first_name }} {{ $review->user?->last_name }}
                                </h2>
                                <span class="rounded-full border px-3 py-1 text-xs font-medium {{ $review->getStatusColour() }} dark:border-transparent">
                                    {{ $review->review_status }}
                                </span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ optional($review->created_at)->format('d M Y H:i') }}</span>
                            </div>

                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $review->user?->email ?? 'No email available' }}</p>

                            <div class="mt-4 flex text-lg text-amber-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span>{!! $i <= $review->rating ? '&starf;' : '&star;' !!}</span>
                                @endfor
                            </div>

                            <p class="mt-4 whitespace-pre-line text-sm leading-7 text-gray-700 dark:text-gray-300">{{ $review->review_text }}</p>
                        </div>

                        <div class="w-full max-w-xs rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-slate-950/60">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Moderation Action</p>
                            <form method="POST" action="{{ route('admin.reviews.update', $review) }}" class="mt-4 space-y-3">
                                @csrf
                                @method('PATCH')
                                <div class="grid grid-cols-2 gap-2">
                                    <button type="submit" name="review_status" value="Approved" class="rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                        Approve
                                    </button>
                                    <button type="submit" name="review_status" value="Rejected" class="rounded-2xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-700">
                                        Reject
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <p class="rounded-3xl border border-gray-200 bg-white px-6 py-8 text-sm text-gray-500 shadow-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400">No website reviews matched this filter.</p>
            @endforelse

            <div>{{ $reviews->links() }}</div>
        </section>
    </section>
</x-admin-layout>
