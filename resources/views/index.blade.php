<x-header></x-header>
<x-layout>

<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

<div class="min-h-screen bg-orange-50 dark:bg-[#0f0a1e] transition-colors duration-500">

    <section class="relative overflow-hidden px-4 pt-16 pb-24 sm:pt-24 sm:pb-32">

        <!-- bubbly background -->
        <div class="pointer-events-none absolute -top-32 -left-32 w-[500px] h-[500px] rounded-full opacity-30 dark:opacity-20 blur-3xl bg-orange-400 dark:bg-violet-700"></div>
        <div class="pointer-events-none absolute top-10 -right-24 w-[400px] h-[400px] rounded-full opacity-20 dark:opacity-10 blur-3xl bg-amber-300 dark:bg-purple-600"></div>

        <div class="relative z-10 max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">

            <div class="py-3">
                <h1 class="text-5xl sm:text-6xl font-black leading-tight tracking-tight mb-6 text-gray-900 dark:text-white">
                    Your Dream Build,<br>
                    <span class="text-orange-500 dark:text-violet-400">No Guesswork.</span>
                </h1>

                <p class="text-lg text-gray-500 dark:text-gray-400 mb-8 leading-relaxed max-w-md">
                    CPUs, GPUs, pre-builts, and bundles all in one place. We make PC building feel like a joy, not a headache.
                </p>

                <div class="flex flex-wrap gap-3">
                    <a href="/store"
                       class="inline-flex items-center gap-2 px-7 py-3.5 rounded-2xl font-bold text-white bg-orange-500 dark:bg-violet-600 hover:bg-orange-600 dark:hover:bg-violet-700 shadow-lg shadow-orange-300/50 dark:shadow-violet-900/50 transition-all duration-200 hover:scale-105 active:scale-95">
                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                        Shop Now
                    </a>
                    <a href="/build-guide"
                       class="inline-flex items-center gap-2 px-7 py-3.5 rounded-2xl font-bold border-2 border-orange-200 dark:border-violet-600 text-gray-700 dark:text-gray-200 bg-white dark:bg-violet-950/40 hover:border-orange-400 dark:hover:border-violet-500 transition-all duration-200 hover:scale-105 active:scale-95">
                        <i data-lucide="book-open" class="w-4 h-4 text-orange-500 dark:text-violet-400"></i>
                        Build Guide
                    </a>
                </div>

                <div class="flex flex-wrap gap-6 mt-10">
                    <div class="flex items-center gap-2 text-sm font-semibold text-gray-500 dark:text-gray-400">
                        <i data-lucide="shield-check" class="w-4 h-4 text-orange-500 dark:text-violet-400"></i> 2-Year Warranty
                    </div>
                    <div class="flex items-center gap-2 text-sm font-semibold text-gray-500 dark:text-gray-400">
                        <i data-lucide="truck" class="w-4 h-4 text-orange-500 dark:text-violet-400"></i> Fast Delivery
                    </div>
                    <div class="flex items-center gap-2 text-sm font-semibold text-gray-500 dark:text-gray-400">
                        <i data-lucide="headphones" class="w-4 h-4 text-orange-500 dark:text-violet-400"></i> Expert Support
                    </div>
                </div>
            </div>

            <div class="relative hidden md:block">
                <div class="absolute inset-0 -m-4 rounded-[2.5rem] blur-2xl opacity-20 bg-gradient-to-br from-orange-400 to-amber-300 dark:from-violet-600 dark:to-purple-400"></div>
                <div class="relative rounded-[2.5rem] overflow-hidden border-4 border-orange-200 dark:border-violet-700 shadow-2xl">
                    <img src="/images/hero_pc.jpg" alt="Cool PC" class="w-full h-80 object-cover transition-transform duration-700 hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-orange-900/20 dark:from-violet-900/30 to-transparent"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 py-16 max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-gray-900 dark:text-white mb-2">Browse the Shop</h2>
            <p class="text-gray-500 dark:text-gray-400">Whatever you need, we've got it.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <a href="/store?selectedCategories[0]=1"
               class="group relative rounded-[1.75rem] overflow-hidden border-2 border-orange-200 dark:border-violet-800 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-[#1a1030] dark:to-[#150d28] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-orange-200/50 dark:hover:shadow-violet-900/50">
                <div class="absolute top-0 right-0 w-32 h-32 rounded-full opacity-20 -translate-y-8 translate-x-8 bg-orange-400 dark:bg-violet-600"></div>
                <div class="p-8">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 shadow-lg bg-gradient-to-br from-orange-400 to-orange-600 dark:from-violet-500 dark:to-violet-700">
                        <i data-lucide="cpu" class="w-7 h-7 text-white"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-gray-100 mb-2">Components</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">CPUs, GPUs, RAM, SSDs & more.</p>
                    <span class="inline-flex items-center gap-1 text-sm font-bold text-orange-600 dark:text-violet-400">
                        Shop Parts <i data-lucide="arrow-right" class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>

            <a href="/store?selectedCategories[0]=2"
               class="group relative rounded-[1.75rem] overflow-hidden border-2 border-orange-200 dark:border-violet-800 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-[#1a1030] dark:to-[#150d28] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-orange-200/50 dark:hover:shadow-violet-900/50">
                <div class="absolute top-0 right-0 w-32 h-32 rounded-full opacity-20 -translate-y-8 translate-x-8 bg-amber-400 dark:bg-purple-600"></div>
                <div class="p-8">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 shadow-lg bg-gradient-to-br from-amber-400 to-orange-500 dark:from-purple-500 dark:to-violet-700">
                        <i data-lucide="monitor" class="w-7 h-7 text-white"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-gray-100 mb-2">Pre-Built PCs</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Plug in and play. Ready to game.</p>
                    <span class="inline-flex items-center gap-1 text-sm font-bold text-orange-600 dark:text-violet-400">
                        Shop Pre-Builts <i data-lucide="arrow-right" class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>

            <a href="/store?selectedCategories[0]=3"
               class="group relative rounded-[1.75rem] overflow-hidden border-2 border-orange-200 dark:border-violet-800 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-[#1a1030] dark:to-[#150d28] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-orange-200/50 dark:hover:shadow-violet-900/50">
                <div class="absolute top-0 right-0 w-32 h-32 rounded-full opacity-20 -translate-y-8 translate-x-8 bg-yellow-400 dark:bg-indigo-600"></div>
                <div class="p-8">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 shadow-lg bg-gradient-to-br from-yellow-400 to-orange-500 dark:from-indigo-500 dark:to-violet-700">
                        <i data-lucide="package" class="w-7 h-7 text-white"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-gray-100 mb-2">Bundles</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Curated sets. Save more, build more.</p>
                    <span class="inline-flex items-center gap-1 text-sm font-bold text-orange-600 dark:text-violet-400">
                        Shop Bundles <i data-lucide="arrow-right" class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>

        </div>
    </section>

    <section class="px-4 py-16 bg-gradient-to-b from-orange-50 to-orange-100 dark:from-[#130920] dark:to-[#0f0a1e]">
        <div class="max-w-6xl mx-auto">

            <div class="flex items-center justify-between mb-10 flex-wrap gap-4">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 dark:text-white">Best Sellers 🔥</h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Our most-loved products right now.</p>
                </div>
                <a href="/store"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border-2 border-orange-200 dark:border-violet-700 font-bold text-sm text-orange-600 dark:text-violet-400 bg-white dark:bg-violet-950/40 transition-all duration-200 hover:scale-105">
                    View All <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($bestSellers as $product)
                    @php $avgRating = $product->reviews_avg_rating ?? 0; @endphp
                    <form method="POST" action="{{ route('basket.add') }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        @csrf
                        <div class="group rounded-[1.75rem] border-2 border-orange-200 dark:border-violet-800 overflow-hidden bg-white dark:bg-[#1a1030] transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-orange-200/50 dark:hover:shadow-violet-900/50">
                            <a href="{{ route('product.show', $product->id) }}" class="block">
                                <x-product-card
                                    title="{{ $product->product_name }}"
                                    tagline="{{ $product->product_tagline }}"
                                    price="{{ $product->product_price }}"
                                    image="{{ $product->product_image }}"
                                    :avgRating="$avgRating"
                                    :context="'index'"
                                />
                            </a>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-4 py-20 max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-black text-gray-900 dark:text-white mb-3">Why Happy Hardware?</h2>
            <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">We're not just a shop — we're your building buddy.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="text-center p-8 rounded-[1.75rem] border-2 border-orange-200 dark:border-violet-800 bg-orange-50 dark:bg-[#1a1030] transition-all hover:shadow-xl hover:shadow-orange-100 dark:hover:shadow-violet-900/30">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5 text-2xl shadow-lg bg-gradient-to-br from-orange-400 to-orange-600 dark:from-violet-500 dark:to-violet-700">
                    📦
                </div>
                <h3 class="text-lg font-black text-gray-900 dark:text-gray-100 mb-2">Expert-Picked Bundles</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Our team picks the best compatible parts so you don't have to.</p>
            </div>

            <div class="text-center p-8 rounded-[1.75rem] border-2 border-orange-200 dark:border-violet-800 bg-orange-50 dark:bg-[#1a1030] transition-all hover:shadow-xl hover:shadow-orange-100 dark:hover:shadow-violet-900/30">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5 text-2xl shadow-lg bg-gradient-to-br from-amber-400 to-orange-500 dark:from-purple-500 dark:to-violet-700">
                    🔧
                </div>
                <h3 class="text-lg font-black text-gray-900 dark:text-gray-100 mb-2">Compatibility Checker</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Use our Part Picker to make sure everything works together perfectly.</p>
            </div>

            <div class="text-center p-8 rounded-[1.75rem] border-2 border-orange-200 dark:border-violet-800 bg-orange-50 dark:bg-[#1a1030] transition-all hover:shadow-xl hover:shadow-orange-100 dark:hover:shadow-violet-900/30">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5 text-2xl shadow-lg bg-gradient-to-br from-yellow-400 to-orange-500 dark:from-indigo-500 dark:to-violet-700">
                    📖
                </div>
                <h3 class="text-lg font-black text-gray-900 dark:text-gray-100 mb-2">Step-by-Step Guides</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">Never built a PC? No worries. Our guides walk you through every step.</p>
            </div>

        </div>
    </section>

    <section class="px-4 py-16 bg-gradient-to-b from-orange-50 to-orange-100 dark:from-[#0f0a1e] dark:to-[#130920]">
        <div class="max-w-6xl mx-auto">

            <div class="flex items-center justify-center gap-4 mb-10 flex-wrap">
                <img src="{{ asset('images/reviewmouse.png') }}" class="w-16 h-16 object-contain hidden sm:block -scale-x-100">
                <div class="text-center">
                    <h2 class="text-3xl font-black text-gray-900 dark:text-white">What People Say 💬</h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Real reviews from real builders.</p>
                </div>
                <img src="{{ asset('images/reviewmouse.png') }}" class="w-16 h-16 object-contain hidden sm:block">
            </div>

            @auth
                @if($userReview)
                    <div class="max-w-2xl mx-auto mb-10 p-6 rounded-[1.75rem] border-2 border-orange-200 dark:border-violet-800 bg-orange-50 dark:bg-[#1a1030]">
                        <div class="flex items-center justify-between mb-3 flex-wrap gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-black text-white text-sm bg-gradient-to-br from-orange-400 to-orange-600 dark:from-violet-500 dark:to-violet-700">
                                    {{ substr($userReview->user->first_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white text-sm">Your Review</p>
                                    <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $userReview->review_status == 'Approved' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $userReview->review_status }}
                                    </span>
                                </div>
                            </div>
                            <form action="{{ route('website-reviews.destroy', $userReview->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                                @csrf @method('DELETE')
                                <button class="text-sm text-red-400 hover:text-red-600 font-semibold">Delete</button>
                            </form>
                        </div>
                        <div class="flex gap-0.5 mb-2">
                            @for($i=1; $i<=5; $i++)
                                <span class="text-lg {{ $i <= $userReview->rating ? 'text-orange-500 dark:text-violet-400' : 'text-gray-200 dark:text-gray-700' }}">★</span>
                            @endfor
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 italic text-sm">"{{ $userReview->review_text }}"</p>
                    </div>
                @else
                    <div class="text-center mb-10">
                        <button onclick="document.getElementById('websiteReviewPopup').classList.remove('hidden')"
                                class="inline-flex items-center gap-2 px-7 py-3.5 rounded-2xl font-bold text-white bg-orange-500 dark:bg-violet-600 hover:bg-orange-600 dark:hover:bg-violet-700 shadow-lg shadow-orange-300/50 dark:shadow-violet-900/50 transition-all duration-200 hover:scale-105">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                            Write a Review
                        </button>
                    </div>
                @endif
            @endauth

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach($websiteReviews as $review)
                    <div class="bg-white dark:bg-[#1a1030] p-6 rounded-[1.75rem] border-2 border-orange-200 dark:border-violet-800 transition-all hover:scale-[1.01] hover:shadow-xl flex flex-col justify-between">
                        <div>
                            <div class="flex gap-0.5 mb-3">
                                @for($i=1; $i<=5; $i++)
                                    <span class="text-base {{ $i <= $review->rating ? 'text-orange-500 dark:text-violet-400' : 'text-gray-200 dark:text-gray-700' }}">★</span>
                                @endfor
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 italic text-sm leading-relaxed mb-5">"{{ $review->review_text }}"</p>
                        </div>
                        <div class="flex items-center gap-3 border-t border-orange-100 dark:border-violet-900 pt-4">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-white text-xs shrink-0 bg-gradient-to-br from-orange-400 to-orange-600 dark:from-violet-500 dark:to-violet-700">
                                {{ substr($review->user->first_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $review->user->first_name }} {{ $review->user->last_name }}</p>
                                <p class="text-xs text-gray-400">{{ $review->created_at ? $review->created_at->format('M d, Y') : 'Recently' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $websiteReviews->links() }}
            </div>
        </div>
    </section>

    <section class="px-4 py-16 max-w-6xl mx-auto">
        <div class="relative rounded-[2.5rem] overflow-hidden p-10 sm:p-16 text-center text-white bg-gradient-to-br from-orange-400 via-orange-500 to-orange-700 dark:from-violet-700 dark:via-violet-800 dark:to-purple-900">

            <div class="pointer-events-none absolute -top-20 -right-20 w-72 h-72 rounded-full opacity-20 bg-yellow-300 dark:bg-violet-400"></div>
            <div class="pointer-events-none absolute -bottom-16 -left-16 w-56 h-56 rounded-full opacity-10 bg-white dark:bg-purple-300"></div>

            <div class="relative z-10">
                <div class="text-5xl mb-5">🖥️</div>
                <h2 class="text-3xl sm:text-4xl font-black mb-4">Not sure where to start?</h2>
                <p class="text-orange-100 dark:text-violet-200 max-w-md mx-auto mb-8 leading-relaxed">
                    Use our Part Picker to check compatibility, or read one of our friendly guides — we make it easy.
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('part-picker') }}"
                       class="inline-flex items-center gap-2 px-7 py-3.5 rounded-2xl font-bold bg-white text-orange-600 dark:text-violet-700 hover:bg-orange-50 dark:hover:bg-violet-50 transition-all duration-200 hover:scale-105 shadow-lg">
                        <i data-lucide="sliders" class="w-4 h-4"></i>
                        Part Picker
                    </a>
                    <a href="/build-guide"
                       class="inline-flex items-center gap-2 px-7 py-3.5 rounded-2xl font-bold border-2 border-white/40 text-white hover:bg-white/10 transition-all duration-200 hover:scale-105">
                        <i data-lucide="book-open" class="w-4 h-4"></i>
                        Build Guide
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>

{{-- ===== REVIEW POPUP ===== --}}
<div id="websiteReviewPopup" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-[#1a1030] p-8 rounded-[1.75rem] max-w-md w-full shadow-2xl border-2 border-orange-200 dark:border-violet-700">
        <h2 class="text-2xl font-black mb-1 text-gray-900 dark:text-white">Write a Review</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Share your Happy Hardware experience.</p>
        <form action="{{ route('website-reviews.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Rating</label>
                <select name="rating" class="w-full border-2 border-orange-200 dark:border-violet-700 rounded-xl p-2.5 text-sm font-semibold bg-white dark:bg-[#130920] text-gray-800 dark:text-gray-200 focus:outline-none">
                    <option value="5">⭐⭐⭐⭐⭐ — Amazing!</option>
                    <option value="4">⭐⭐⭐⭐ — Great</option>
                    <option value="3">⭐⭐⭐ — Good</option>
                    <option value="2">⭐⭐ — Could be better</option>
                    <option value="1">⭐ — Not great</option>
                </select>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Your Feedback</label>
                <textarea name="review_text" rows="4"
                    class="w-full border-2 border-orange-200 dark:border-violet-700 rounded-xl p-3 text-sm bg-white dark:bg-[#130920] text-gray-800 dark:text-gray-200 focus:outline-none resize-none"
                    placeholder="What did you think of our service?"></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('websiteReviewPopup').classList.add('hidden')"
                        class="px-5 py-2 text-sm font-semibold text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancel</button>
                <button type="submit"
                        class="px-7 py-2.5 rounded-xl font-bold text-white text-sm bg-orange-500 dark:bg-violet-600 hover:bg-orange-600 dark:hover:bg-violet-700 transition hover:scale-105">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();
</script>

</x-layout>
<x-footer></x-footer>
