<x-header></x-header>

<x-layout>
   <div class="grid grid-cols-1 md:grid-cols-2 bg-gray-200 dark:bg-gray-800 mb-10 md:mb-12 rounded-3xl overflow-hidden shadow-xl">
    <div class="relative h-64 overflow-hidden sm:h-80 md:h-auto">
        <img id="hero-pc-img" src="/images/orangepc.png" alt="Cool PC" class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent to-gray-200/30 dark:to-gray-800/30 md:block hidden"></div>
    </div>

    <div class="p-8 sm:p-10 md:p-14 flex flex-col justify-center gap-6">

        <div>
            <span class="inline-block text-xs font-bold tracking-widest uppercase text-gray-500 dark:text-gray-400 mb-3">Happy Hardware</span>
            <h1 class="text-3xl sm:text-4xl font-black leading-tight text-gray-900 dark:text-white">
                Your Dream Build.<br>
                <span class="text-gray-600 dark:text-gray-300">Without the Guesswork.</span>
            </h1>
        </div>

        <p class="text-gray-600 dark:text-gray-400 leading-relaxed max-w-sm">
            We offer the best prices on CPUs, GPUs and pre-builts. Better service, better gaming.
        </p>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="/store"
               class="inline-flex items-center justify-center gap-2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-6 py-3 rounded-xl font-bold text-sm hover:bg-gray-700 dark:hover:bg-gray-100 transition-all duration-200 hover:scale-105 active:scale-95 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z"/></svg>
                Shop Now
            </a>
            <a href="/build-guide"
               class="inline-flex items-center justify-center gap-2 border-2 border-gray-900 dark:border-gray-400 text-gray-900 dark:text-gray-300 px-6 py-3 rounded-xl font-bold text-sm hover:bg-gray-900 dark:hover:bg-gray-700 hover:text-white transition-all duration-200 hover:scale-105 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
                Build Guide
            </a>
        </div>

        <div class="flex items-center gap-6 pt-2 border-t border-gray-300 dark:border-gray-700">
            <div class="text-center">
                <p class="text-lg font-black text-gray-900 dark:text-white">500+</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Products</p>
            </div>
            <div class="w-px h-8 bg-gray-300 dark:bg-gray-700"></div>
            <div class="text-center">
                <p class="text-lg font-black text-gray-900 dark:text-white">2 Year</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Warranty</p>
            </div>
            <div class="w-px h-8 bg-gray-300 dark:bg-gray-700"></div>
            <div class="text-center">
                <p class="text-lg font-black text-gray-900 dark:text-white">Free</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">UK Shipping</p>
            </div>
        </div>

    </div>
</div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

            <a href="/store?selectedCategories[0]=1" class="block group">
                <div class="transform transition duration-300 hover:translate-y-2 hover:shadow-lg">
                    <div class="h-48 bg-gray-300 rounded-lg mb-3 flex items-center justify-center group-hover:bg-gray-400 transition">
                        <span class="text-gray-500 font-bold text-xl">Components</span>
                    </div>
                </div>
                <h3 class="text-lg font-semibold">Shop Individual Parts</h3>
            </a>

            <a href="/store?selectedCategories[0]=2" class="block group">
                <div class="transform transition duration-300 hover:translate-y-1 hover:shadow-lg">
                    <div class="h-48 bg-gray-300 rounded-lg mb-3 flex items-center justify-center group-hover:bg-gray-400 transition">
                        <span class="text-gray-500 font-bold text-xl">Pre-Built</span>
                    </div>
                </div>

                <h3 class="text-lg font-semibold">Ready to Game</h3>
            </a>

            <a href="/store?selectedCategories[0]=3" class="block group">
                <div class="transform transition duration-300 hover:translate-y-2 hover:shadow-lg">
                    <div class="h-48 bg-gray-300 rounded-lg mb-3 flex items-center justify-center group-hover:bg-gray-400 transition">
                        <span class="text-gray-500 font-bold text-xl">Bundles</span>
                    </div>
                </div>

                <h3 class="text-lg font-semibold">Save with Bundles</h3>
            </a>
        </div>

    </div>

    <div class="bg-gray-100 py-12 mb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="text-3xl font-bold text-center mb-10">Best Sellers</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                @foreach ( $bestSellers as $product )

                    @php
                        $avgRating = $product->reviews_avg_rating ?? 0;
                    @endphp

                    <form method="POST" action="{{ route('basket.add') }}">

                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <input type="hidden" name="quantity" value="1">
                        @csrf
                            <div class="transform transition duration-200 hover:scale-105 hover:shadow-lg">
                                <a href="{{ route('product.show', $product->id)}}" class="block">
                                    <x-product-card
                                        title="{{$product->product_name}}"
                                       tagline="{{$product->product_tagline}}"
                                        price="{{$product->product_price}}"
                                        image="{{$product->product_image}}"
                                        :avgRating="$avgRating"
                                        :context="'index'"

                                    />
                                </a>
                            </div>
                    </form>

                @endforeach

            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center w-full justify-center">
                <div class="hidden md:block -mt-12">
                    <img src="{{asset('images/reviewmouse.png')}}" class="w-40 h-40 object-scale-down">
                </div>
                <div class="text-center mb-10 md:mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">What Our Users Say</h2>
                    <p class="text-gray-600 mt-2">Real feedback from our community.</p>
                </div>
                <div class="hidden md:block -mt-12">
                    <img src="{{asset('images/reviewmouse.png')}}" class="w-40 h-40 object-scale-down -scale-x-100">
                </div>
            </div>

            @auth
                @if($userReview)
                    <div class="max-w-3xl mx-auto mb-12 bg-white p-5 sm:p-6 rounded-2xl border-2 border-indigo-100 shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">
                                    {{ substr($userReview->user->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Your Review</h3>
                                    <span class="text-xs px-2 py-1 rounded-full {{ $userReview->review_status == 'Approved' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $userReview->review_status }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex gap-4 text-sm">
                                <form action="{{ route('website-reviews.destroy', $userReview->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                </form>
                            </div>
                        </div>
                        <div class="flex text-yellow-400 mb-2">
                            @for($i=1; $i<=5; $i++)
                                <span class="text-lg">{{ $i <= $userReview->rating ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                        <p class="text-gray-700 italic">"{{ $userReview->review_text }}"</p>
                    </div>
                @else
                    <div class="text-center mb-12">
                        <button onclick="document.getElementById('websiteReviewPopup').classList.remove('hidden')"
                                class="bg-indigo-600 text-white px-8 py-3 rounded-full font-bold hover:bg-indigo-700 transition shadow-lg">
                            Write a Website Review
                        </button>
                    </div>
                    </div>
                @endif
            @endauth

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            @foreach($websiteReviews as $review)
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between transition-transform hover:scale-[1.02]">
                    <div>
                        <div class="flex text-yellow-400 mb-4">
                            @for($i=1; $i<=5; $i++)
                                <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                        <p class="text-gray-600 italic leading-relaxed mb-6">"{{ $review->review_text }}"</p>
                    </div>

                    <div class="flex items-center gap-3 border-t pt-6">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-semibold text-gray-500">
                            {{ substr($review->user->first_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $review->user->first_name }} {{ $review->user->last_name }}</p>
                            <p class="text-xs text-gray-400">{{ $review->created_at ? $review->created_at->format('M d, Y') : 'Recently' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $websiteReviews->links() }}
            </div>
        </div>
    </div>
    <br>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 text-center">

        <h2 class="text-2xl sm:text-3xl font-bold mb-4">Not sure where to start?</h2>
        <p class="text-gray-600 mb-10 sm:mb-12">Save your time of researching, and use our resources to configure your computer.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

        <div class="flex flex-col item-center">
            <div class="bg-gray-200 p-6 rounded-2xl mb-4 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 0 1 1.872 1.002l.164.246a2.25 2.25 0 0 0 1.872 1.002h2.092a2.25 2.25 0 0 0 1.872-1.002l.164-.246A2.25 2.25 0 0 1 16.954 9h4.636M2.41 9a2.25 2.25 0 0 0-.16.832V12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 0 1 .382-.632l3.285-3.832a2.25 2.25 0 0 1 1.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>

            </div>
            <p class="bg-gray-200 p-2 px-4 rounded text-sm">Purchase Bundles, chosen by our experts</p>
        </div>

        <div class="flex flex-col item-center">
            <div class="bg-gray-200 p-6 rounded-2xl mb-4 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>

            </div>
            <p class="bg-gray-200 p-2 px-4 rounded text-sm">Configure and check for compactibility to build your dream PC</p>
        </div>

        <div class="flex flex-col item-center">
            <div class="bg-gray-200 p-6 rounded-2xl mb-4 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607ZM10.5 7.5v6m3-3h-6" />
                </svg>

            </div>
            <p class="bg-gray-200 p-2 px-4 rounded text-sm">To learn the essentials of building a PC, read our guides.</p>
        </div>

        </div>

        <div class="mt-12">
            <a href="/build-guide" class="bg-gray-900 dark:bg-gray-800 text-white px-8 py-3 rounded hover:bg-gray-700 transition">
                Start Now
            </a>
        </div>
    </div>

    <div id="websiteReviewPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 p-4 flex items-center justify-center z-50">
        <div class="bg-white p-6 sm:p-8 rounded-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-bold mb-4">Write a Review</h2>

            <form action="{{ route('website-reviews.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Rating</label>
                    <select name="rating" class="w-full border rounded-lg p-2">
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2">Your Feedback</label>
                    <textarea name="review_text" rows="4" class="w-full border rounded-lg p-2" placeholder="What did you think of our service?"></textarea>
                </div>

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <button type="button" onclick="document.getElementById('websiteReviewPopup').classList.add('hidden')" class="px-4 py-2 text-gray-500">Cancel</button>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold">Submit Review</button>
                </div>
            </form>
        </div>
    </div>


</x-layout>

<x-footer></x-footer>

<script>
    //script that changes the image of the website based on light mode and dark mode
    function updateHeroImage() {
        var img = document.getElementById('hero-pc-img');
        if (!img) return;
        img.src = document.documentElement.classList.contains('dark') ? '/images/hero_pc.png' : '/images/orangepc.png';
    }
    updateHeroImage();

    //mutations check for changes in the website
    new MutationObserver(updateHeroImage).observe(
        document.documentElement, { attributes: true, attributeFilter: ['class'] }
    );
</script>
