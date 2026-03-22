<!--The title, brand and review-->
<div class="mb-8 md:mb-10">
    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-normal mb-2 tracking-tight break-words">{{ $title }}</h1>
    <h2 class="text-xl sm:text-2xl font-bold">{{ $brandName}}</h2>
    <h3 class="text-base sm:text-lg font-bold mb-5 sm:mb-6 text-gray-500"> {{ $pcPart}} </h3>
    <!-- start reviews of the product-->
    <div class="flex flex-wrap items-center gap-3 sm:gap-4">
        <!-- labels and star -->
        <div class="flex text-black gap-2">
          <div class="text-yellow-400 text-lg">
            @for ($i = 1; $i <=5 ; $i++)
                {{ $i <= $avgRating ? '★' : '☆' }}
            @endfor

        </div>
    </div>
        <span class="text-sm text-gray-500 font-bold">{{ $avgRating }}/5</span>

    </div>


        @if ($totalReviews == 1)
            <span class="text-sm text-gray-500 font-extrabold">{{ $totalReviews }} Review</span>

        @else
            <span class="text-sm text-gray-500 font-extrabold">{{ $totalReviews }} Reviews</span>
        @endif
</div>
