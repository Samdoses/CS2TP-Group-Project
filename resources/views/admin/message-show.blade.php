<x-admin-layout title="Message Details">
    <section class="mx-auto max-w-5xl space-y-8 px-4 py-8">
        @include('admin.partials.alerts')

        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">Message Detail</p>
                <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $message->subject }}</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
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
            </div>
            <a href="{{ route('admin.messages.index') }}" class="rounded-full border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-white/20 dark:text-gray-300 dark:hover:bg-white/10">Back to inbox</a>
        </div>

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <span class="text-sm text-gray-500 dark:text-gray-400">Received {{ optional($message->created_at)->format('d M Y H:i') }}</span>
                @if ($message->admin_reply)
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-200">Reply sent {{ optional($message->admin_replied_at)->format('d M Y H:i') }}</span>
                @else
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-200">Awaiting reply</span>
                @endif
            </div>

            <div class="mt-5 rounded-2xl bg-gray-50 p-4 text-sm leading-7 text-gray-700 dark:bg-slate-950/60 dark:text-gray-300">
                {!! nl2br(e($message->message)) !!}
            </div>
        </section>

        <section class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Reply to Customer</h2>
            <form method="POST" action="{{ route('admin.messages.reply', $message) }}" class="mt-5 space-y-4">
                @csrf
                <div>
                    <label for="admin_reply" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reply</label>
                    <textarea id="admin_reply" name="admin_reply" rows="8" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm focus:border-gray-600 focus:outline-none dark:border-gray-700 dark:bg-slate-950 dark:text-white" required>{{ old('admin_reply', $message->admin_reply) }}</textarea>
                </div>
                <button type="submit" class="rounded-2xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                    {{ $message->admin_reply ? 'Update Reply' : 'Send Reply' }}
                </button>
            </form>
        </section>
    </section>
</x-admin-layout>
