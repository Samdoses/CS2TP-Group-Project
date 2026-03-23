<section class="w-full space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">My Reviews</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Browse your history of reviewed products. You can share your feedback for any item once your order has been delivered. Simply visit your
            <a href="{{ route('profile.orders') }}" class="font-bold transition-colors duration-200 hover:underline">
                Order History
            </a>
            to start a new review for your recent purchases.</p>
    </header>

    <div class="mt-6 space-y-4">
        @if($reviews->count() > 0)
            @foreach($reviews as $review)
                <div class="flex gap-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-slate-950/50">
                    <div class="h-20 w-20 flex-shrink-0">
                        @if($review->review_image)
                            <a href="{{ route('reviews.image.show', $review->id) }}" class="group block">
                                <img src="{{ asset('images/reviews/' . $review->review_image) }}"
                                     class="h-full w-full rounded object-cover shadow-inner"
                                     alt="Review photo">
                            </a>
                        @else
                            <div class="flex h-full w-full items-center justify-center rounded border border-dashed border-gray-200 px-1 text-center text-[10px] text-gray-400 dark:border-gray-700 dark:text-gray-500">
                                No Photo
                            </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div class="flex flex-wrap items-center gap-3">
                                <a href="/product/{{$review->product->id}}" class="font-bold text-gray-800 transition hover:text-indigo-600 dark:text-white dark:hover:text-indigo-300">
                                    {{ $review->product->product_name ?? 'Product removed from sale' }}
                                </a>
                                <span class="rounded-full border px-3 py-1 text-xs font-semibold {{ $review->getStatusColour() }}">
                                    {{ $review->review_status }}
                                </span>
                            </div>

                            <span class="text-xs text-gray-400 dark:text-gray-500">{{ $review->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="my-1 flex text-xs text-yellow-400">
                            @for ($i = 1; $i <= 5; $i++)
                                <span>{!! $i <= $review->rating ? '&starf;' : '&star;' !!}</span>
                            @endfor
                        </div>

                        @if(strlen($review->review_text) > 150)
                            <p class="text-sm italic text-gray-600 dark:text-gray-300">"{{ \Illuminate\Support\Str::limit($review->review_text, 110, '...') }}"</p>
                            <a href="{{ route('reviews.image.show', $review->id) }}"
                               class="ml-1 font-medium text-indigo-600 hover:underline dark:text-indigo-300">
                                Read full review
                            </a>
                        @elseif (empty($review->review_text))
                            <p class="text-xs italic text-gray-400 dark:text-gray-500">No written comment provided.</p>
                        @else
                            <p class="text-sm italic text-gray-600 dark:text-gray-300">"{{ $review->review_text }}"</p>
                            <a href="{{ route('reviews.image.show', $review->id) }}"
                               class="ml-1 font-medium text-indigo-600 hover:underline dark:text-indigo-300">
                                Read full review
                            </a>
                        @endif

                        <div class="mt-3 flex justify-end gap-3 border-t border-gray-200 pt-2 dark:border-gray-700">
                            <a href="{{ route('reviews.edit', $review->id) }}" class="flex items-center text-xs font-semibold text-indigo-600 transition duration-200 hover:text-indigo-800 dark:text-indigo-300 dark:hover:text-indigo-200">
                                <i class="fas fa-edit mr-1"></i> Edit Review
                            </a>
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this review?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center text-xs font-semibold text-red-500 transition duration-200 hover:text-red-700 dark:text-red-300 dark:hover:text-red-200">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete Review
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-sm italic text-gray-500 dark:text-gray-400">You haven't written any reviews yet.</p>
        @endif

        <div class="mt-4">
            {{ $reviews->links() }}
        </div>
    </div>
</section>
