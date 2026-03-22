@props(['title', 'tagline', 'price', 'image', 'context', 'avgRating' => 0])

<div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm flex flex-col items-center text-center h-full">
    <div class="w-full bg-white h-40 sm:h-48 rounded mb-5 sm:mb-6 overflow-hidden flex items-center justify-center">
        <img src="{{ $image ?? '' }}" alt="{{ $title }}" class="max-w-full max-h-full object-scale-down">
    </div>

    <h3 class="text-lg sm:text-xl font-bold mb-2">{{ $title }}</h3>

    <p class="text-gray-500 text-sm mb-6 flex-grow line-clamp-3">
        {{ $tagline }}
    </p>

    <!-- product stars and rating on the store page -->
    <div class="text-sm mb-3">
        @if($avgRating > 0)
            @for ($i = 1; $i <= 5; $i++)
                <span class="text-yellow-400"> {{ $i <= $avgRating ? '★' : '☆' }} </span>
            @endfor
            <span class="text-gray-400"> | </span>
            <span class="text-gray-800"> {{ number_format($avgRating, 1) }} / 5 </span>
        @else
        <div>
            <div class="flex items-center justify-center text-gray-300">
            <span>☆ ☆ ☆ ☆ ☆</span>
            <span class="ml-2 text-gray-400 italic text-xs">No reviews yet</span>
            </div>
        </div>
        @endif
    </div>

    @if($context !== 'index')
        <div class="mt-auto w-full">
            @if($context !== 'index')
            <div class="mt-auto w-full flex flex-col gap-2">
                <span class="block text-lg font-bold mb-2">£{{ $price }}</span>

                {{-- BUY NOW: Uses formaction to hijack the parent form and go to checkout --}}
                <button type="submit" formmethod="GET" formaction="{{ route('checkout.direct') }}" class="w-full bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-700 transition">
                    Buy now
                </button>

                {{-- ADD TO BASKET: No formaction, so it uses the form's default basket.add route --}}
                <button type="submit" class="w-full p-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    Add to Basket
                </button>
            </div>
            @endif
        </div>
    @endif

</div>
