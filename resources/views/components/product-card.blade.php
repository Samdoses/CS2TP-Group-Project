@props(['title', 'description', 'price', 'image'])

<div class="bg-white p-6 rounded-lg shadow-sm flex flex-col items-center text-center h-full">
    <div class="w-full bg-gray-200 h-48 rounded mb-6 overflow-hidden">
        {{-- Use the passed image, or a fallback --}}
        <img src="{{ $image ?? '/images/placeholder.jpg' }}" alt="{{ $title }}" class="w-full h-full object-cover">
    </div>
    
    <h3 class="text-xl font-bold mb-2">{{ $title }}</h3>
    
    <p class="text-gray-500 text-sm mb-6 flex-grow line-clamp-3">
        {{ $description }}
    </p>
    
    <div class="mt-auto w-full">
        <span class="block text-lg font-bold mb-2">£{{ number_format($price, 2) }}</span>
        <button class="w-full bg-gray-800 text-white px-8 py-2 rounded hover:bg-gray-700 transition">
            Buy now
        </button>
    </div>
</div>
