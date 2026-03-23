<!--The border, clickable titles, the rotating arrow-->
@props(['title'])

<div class="mb-4 rounded-2xl border border-gray-200 bg-slate-50 dark:border-gray-800 dark:bg-slate-950/60">
    <details {{ $attributes->merge(['class' => 'group p-4']) }}>

        <summary class="flex cursor-pointer list-none items-center justify-between font-medium text-gray-900 dark:text-white">
            <span>{{ $title }}</span>
            <span class="transition group-open:rotate-180">
                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                    <path d="M6 9l6 6 6-6"></path>
                </svg>
            </span>
        </summary>

        <div class="mt-3 text-sm text-gray-600 dark:text-gray-300">
            {{ $slot }}
        </div>

    </details>
</div>
