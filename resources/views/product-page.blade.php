<x-header></x-header>

<x-layout>

    @if (session('success'))
        <div class="container mx-auto px-6 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container mx-auto px-6 mt-4">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                <p class="font-bold">Error</p>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <main class="container mx-auto px-6 py-8 max-w-7xl">
        <x-product-page-breadcrumb :product="$product"/>


        <form method="POST" action="{{ route('basket.add') }}">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1"> <!-- doing 1 for now -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20">

                @php
                    $title = $product->product_name;
                    $brandName = $product->product_model;
                    $image = $product->product_image;
                    $description = !empty($product->product_description)
                        ? $product->product_description
                        : 'This item is still in development.';
                    $price = number_format($product->product_price, 2);
                    $stock = $product->product_stock;
                    $colour = $product->product_colour;
                    //we will only use approved review stats for the products
                    $approvedReviews = $reviews;

                    $avgRating = round($approvedReviews->avg('rating'), 1);
                    $totalReviews = $approvedReviews->count();
                @endphp

                <x-product-page-gallery :image=$image />

                <div class="flex flex-col pt-2">

                    <x-product-page-header :title=$title :brandName=$brandName :avgRating="$avgRating" :totalReviews="$totalReviews" />

                    <p class="text-gray-700 text-lg mb-10">{{ $description }}</p>

                    <x-product-page-variant-selecter :variant1="$colour" />

                    <x-product-page-purchase-actions :stock=$stock :price=$price />
                </div>
            </div>
        </form>

        @if ($approvedReviews->where('review_status', 'Approved')->count() > 0)
            <div class="w-full p-4 border-2 border-grey-500 rounded-lg mt-10">
                <h3 class="text-lg font-bold mb-4 text-center"> Customer Reviews </h3>

                <!--we filter the collection here so the loop only runs for approved items -->
                @foreach ($approvedReviews->where('review_status', 'Approved') as $review)
                    <div class="flex flex-col gap-4 mb-8 border-b border-gray-100 pb-6 last:border-b-0">
                        <div class="flex gap-6">
                            <!-- photo displaying area -->
                            <div class="w-24 flex-shrink-0">
                                @if ($review->review_image)
                                    <a href="{{ route('reviews.image.show', $review->id) }}" class="block group">
                                        <img src="{{ asset('images/reviews/' . $review->review_image) }}"
                                            class="w-24 h-24 object-cover rounded-lg shadow-sm" alt="Review photo">
                                    </a>
                                @else
                                    <div class="w-24 h-24 bg-gray-50 rounded-lg border border-dashed border-gray-200 flex items-center justify-center text-gray-400 text-[10px]">
                                        No Photo
                                    </div>
                                @endif
                            </div>

                            <!-- text area of the review -->
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-1">
                                    <div>
                                        <span class="font-semibold text-lg block">{{ $review->user->first_name }} {{ $review->user->last_name }}</span>
                                        <div class="flex text-yellow-400 text-sm">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $review->created_at->format('d F Y') }}</span>
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

                                <div class="mt-4 flex items-center gap-3">
                                    <span class="text-[10px] font-bold uppercase text-green-600 bg-green-50 px-2 py-0.5 rounded border border-green-100">
                                        Verified Purchase
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!--pagination links-->
                @if($reviews->hasPages())
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        @endif

    </main>
</x-layout>
<x-footer></x-footer>
