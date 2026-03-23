<x-admin-layout title="Admin Messages">
    <section class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        @include('admin.partials.alerts')

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-medium uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Customer Messages</p>
                    <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Contact Inbox</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Filter new, unreplied, and replied messages, then open a message to reply.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach (['all' => 'All', 'new' => 'New', 'unreplied' => 'Unreplied', 'replied' => 'Replied'] as $value => $label)
                        <a href="{{ route('admin.messages.index', ['filter' => $value]) }}"
                           class="rounded-full px-4 py-2 text-sm font-medium transition {{ $filter === $value ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-white/10 dark:text-gray-300 dark:hover:bg-white/20' }}">
                            {{ $label }}
                            <span class="ml-1 text-xs opacity-75">{{ $messageStats[$value] ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="space-y-4">
            @forelse ($messages as $message)
                <a href="{{ route('admin.messages.show', $message) }}" class="block rounded-3xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-gray-300 hover:shadow-md dark:border-gray-800 dark:bg-gray-900 dark:hover:border-gray-700">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $message->subject }}</h2>
                                @if (! $message->admin_read_at)
                                    <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-medium text-sky-700 dark:bg-sky-500/10 dark:text-sky-200">New</span>
                                @endif
                                @if ($message->admin_reply)
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-200">Replied</span>
                                @else
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-medium text-amber-700 dark:bg-amber-500/10 dark:text-amber-200">Awaiting reply</span>
                                @endif
                            </div>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ $message->sender_name ?: ($message->user ? $message->user->first_name . ' ' . $message->user->last_name : 'Unknown sender') }}
                                @if ($message->sender_email)
                                    · {{ $message->sender_email }}
                                @endif
                            </p>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                {{ $message->contact_reason ? str($message->contact_reason)->replace('_', ' ')->title() : 'Uncategorised' }}
                                @if ($message->order)
                                    · Order #{{ $message->order->id }}
                                @endif
                            </p>
                            <p class="mt-3 text-sm leading-7 text-gray-700 dark:text-gray-300">{{ $message->message }}</p>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 lg:text-right">
                            {{ optional($message->created_at)->format('d M Y H:i') }}
                        </div>
                    </div>
                </a>
            @empty
                <p class="rounded-3xl border border-gray-200 bg-white px-6 py-8 text-sm text-gray-500 shadow-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400">No messages matched this filter.</p>
            @endforelse

            <div>{{ $messages->links() }}</div>
        </section>
    </section>
</x-admin-layout>
