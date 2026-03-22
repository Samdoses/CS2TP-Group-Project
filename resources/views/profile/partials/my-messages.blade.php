<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">My Messages</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">See every contact message you sent and any admin replies.</p>
    </div>

    @if(isset($messages) && $messages->count())
        <div class="space-y-4">
            @foreach($messages as $message)
                <article class="rounded-2xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-700 dark:bg-slate-950/50">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $message->subject }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Sent {{ optional($message->created_at)->format('d M Y H:i') }}</p>
                        </div>
                        @if($message->admin_reply)
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-200">Admin replied</span>
                        @else
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-200">Awaiting reply</span>
                        @endif
                    </div>

                    <div class="mt-4 rounded-xl bg-white p-4 text-sm leading-7 text-gray-700 shadow-sm dark:bg-gray-900 dark:text-gray-300">
                        {!! nl2br(e($message->message)) !!}
                    </div>

                    @if($message->admin_reply)
                        <div class="mt-4 rounded-xl border border-indigo-200 bg-indigo-50 p-4 dark:border-indigo-500/20 dark:bg-indigo-500/10">
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                <h4 class="text-sm font-semibold uppercase tracking-wide text-indigo-700 dark:text-indigo-200">Admin Reply</h4>
                                <span class="text-xs text-indigo-600 dark:text-indigo-300">{{ optional($message->admin_replied_at)->format('d M Y H:i') }}</span>
                            </div>
                            <p class="mt-3 whitespace-pre-line text-sm text-gray-700 dark:text-gray-200">{{ $message->admin_reply }}</p>
                        </div>
                    @endif
                </article>
            @endforeach
        </div>

        <div>{{ $messages->links() }}</div>
    @else
        <div class="rounded-2xl border border-dashed border-gray-300 px-6 py-10 text-center text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
            You have not sent any contact messages yet.
        </div>
    @endif
</div>
