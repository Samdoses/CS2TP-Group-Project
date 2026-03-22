 <x-header></x-header>
    <x-layout>

    @php
        //obtain order quantity for the review
        $itemName = \App\Models\Product::where('id', $review->product_id)
            ->first()->product_name;
    @endphp
    <div class=" min-h-screen flex flex-col items-center justify-center p-4 sm:p-6">
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="flex items-center hover:text-indigo-400 transition font-bold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Product
            </a>
        </div>

        <div class="max-w-4xl w-full bg-black rounded-xl shadow-2xl overflow-hidden border border-gray-700">
        <div class="bg-gray-900 flex items-center justify-center min-h-[300px]">
            @if($review->review_image)
                <img src="{{ asset('images/reviews/' . $review->review_image) }}"
                     class="w-full h-auto max-h-[70vh] object-scale-down mx-auto"
                     alt="Expanded review image">
            @else
                <div class="flex flex-col items-center justify-center text-gray-500 py-20">
                    <svg class="w-20 h-20 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-lg font-medium">No image provided with this review</p>
                </div>
            @endif
        </div>

            <div class="p-4 sm:p-6 bg-gray-800 text-white">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-2">
                    <div class="flex items-center gap-3 flex-wrap">
                        <h2 class="text-lg sm:text-xl font-bold">{{ $review->user->first_name }}'s Review on the {{$itemName}}</h2>

                        <!-- if the review belongs to the current user then it will display the status of the review -->
                        @if(Auth::check() && Auth::id() === $review->user_id)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $review->getStatusColour() }}">
                                {{ $review->review_status }}
                            </span>
                        @endif
                    </div>
                    <span class="text-gray-400 text-sm">{{ $review->created_at->format('M d, Y') }}</span>
                </div>
                <div class="bg-gray-900/50 rounded-lg p-4 sm:p-6 border border-gray-700">
                    <p class="text-gray-200 leading-relaxed whitespace-pre-line text-base sm:text-lg italic break-words overflow-hidden">"{{ $review->review_text }}"</p>
                </div>

                <!--downloadable button so you can download the image from the review -->
                <div class="mt-6 flex flex-wrap items-center justify-between gap-4 border-t border-gray-700 pt-4">
                    @if($review->review_image)
                    <a href="{{ asset('images/reviews/' . $review->review_image) }}" download
                       class="inline-block bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm transition">
                        Download Image
                    </a>
                    @endif
                    @if(Auth::check() && Auth::id() === $review->user_id)
                    <!-- if the review belongs to the current user then they can edit or delete the review -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                        <a href="{{ route('reviews.edit', $review->id) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm font-semibold transition text-center">
                            Edit Review
                        </a>

                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this review permanently?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold transition">
                                Delete Review
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    </x-layout>
    <x-footer></x-footer>

