<section class="w-full space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">My Reviews</h2>
        <p class="mt-1 text-sm text-gray-600">Browse your history of reviewed products. You can share your feedback for any item once your order has been delivered. Simply visit your
            <a href="{{ route('profile.orders') }}" class="font-bold hover:underline transition-colors duration-200">
            Order History
            </a>
            to start a new review for your recent purchases.</p>
    </header>



    <div class="mt-6 space-y-4">
        @if($reviews->count() > 0)
        @foreach($reviews as $review)
            <div class="p-4 border border-gray-200 rounded-lg flex gap-4 bg-white shadow-sm">
                <div class="w-20 h-20 flex-shrink-0">
                    @if($review->review_image)
                        <a href="{{ route('reviews.image.show', $review->id) }}" class="block group">
                            <img src="{{ asset('images/reviews/' . $review->review_image) }}"
                            class="w-full h-full object-cover rounded shadow-inner"
                            alt="Review photo">
                        </a>
                    @else
                        <!-- <img src="placeholder" class="w-24 h-15 object-cover" alt="No Image"> no image -->
                        <div class="w-full h-full rounded border border-dashed border-gray-200 flex items-center justify-center text-gray-400 text-[10px] text-center px-1">
                            No Photo
                        </div>

                    @endif
                </div>

                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="/product/{{$review->product->id}}" class="font-bold text-gray-800 hover:text-indigo-600 transition">
                                {{ $review->product->product_name ?? 'Product removed from sale' }}
                            </a>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $review->getStatusColour() }}">
                                {{ $review->review_status }}
                            </span>
                        </div>

                        <span class="text-xs text-gray-400">{{ $review->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="flex text-yellow-400 text-xs my-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                        @endfor
                    </div>

                    @if(strlen($review->review_text) > 150)
                            <p class="text-sm text-gray-600 italic"> "{{ \Illuminate\Support\Str::limit($review->review_text, 110, '...') }}" </p>
                            <a href="{{ route('reviews.image.show', $review->id) }}"
                                class="text-indigo-600 font-medium hover:underline ml-1">
                                Read full review
                            </a>
                    @elseif (empty($review->review_text))
                            <p class="text-xs text-gray-400 italic">No written comment provided.</p>
                    @else
                        <p class="text-sm text-gray-600 italic">"{{ $review->review_text }}"</p>
                            <a href="{{ route('reviews.image.show', $review->id) }}"
                            class="text-indigo-600 font-medium hover:underline ml-1">
                                Read full review
                            </a>
                    @endif


                        <div class="mt-3 flex justify-end gap-3 border-t border-gray-200 pt-2">
                            <a href="{{ route('reviews.edit', $review->id) }}" class="text-indigo-600 hover:text-indigo-800 text-xs font-semibold flex items-center transition duration-200">
                                <i class="fas fa-edit mr-1"></i> Edit Review
                            </a>
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this review?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold flex items-center transition duration-200">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete Review
                                </button>
                            </form>
                        </div>

                </div>
            </div>
        @endforeach
        @else
            <p class="text-gray-500 text-sm italic">You haven't written any reviews yet.</p>
        @endif

        <div class="mt-4">
            {{ $reviews->links() }}
        </div>
    </div>
</section>
