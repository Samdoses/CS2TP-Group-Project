<!--The title, brand and review-->
<div class="mb-10">
    <h1 class="text-6xl font-normal mb-2 tracking-tight">{{ $title }}</h1>
    <h2 class="text-2xl font-bold mb-6">{{ $brandName}}</h2>

    <div class="flex items-center gap-1">
        <div class="flex text-black gap-1">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
        </div>
        <span class="border-l border-black h-5 mx-3"></span>
        <span class="text-xs text-gray-500">{{ $review }}</span>
    </div>
</div>