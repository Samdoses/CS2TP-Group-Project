<x-header></x-header>

<x-layout>

<div class="min-h-screen bg-gray-50">
    @if (session('status') || session('success'))
        <div class="container mx-auto px-6 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('status') ?? session('success') }}</p>
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

    <div class="container mx-auto p-4 sm:p-6">
        <h1 class="text-2xl sm:text-3xl font-bold mb-6">Write a Review</h1>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="p-5 sm:p-6 md:p-10">
                <!-- php obtain order details of the item -->
                @php
                    $itemQuantity = $order->orderDetails->where('product_id', $product->id)->first()->quantity;
                @endphp
                <!--product information area -->
                <div class="flex flex-col md:flex-row items-center md:items-start gap-5 sm:gap-6 mb-8 pb-8 border-b border-gray-100">
                    <div class="w-24 h-24 bg-gray-100 rounded-lg flex-shrink-0 flex items-center justify-center overflow-hidden">
                        @if($product->product_image)
                            <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" class="object-cover w-full h-full">
                        @else
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @endif

                    </div>
                    <div>
                        <a href="/product/{{$product->id}}" class="text-xl sm:text-2xl font-bold text-gray-800">{{ $product->product_name }}</a>
                        <p class="text-gray-600 mt-1">Purchased {{ $itemQuantity }} in Order #{{ $order->id }}</p>
                        <div class="mt-2">
                             <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $order->getColourStatus() }}">
                                {{ $order->order_status }}
                             </span>
                        </div>
                    </div>
                </div>

                <!--review submission form -->
                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- rating and image -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Rating</label>
                                <select name="rating" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="5">⭐⭐⭐⭐⭐ - Excellent</option>
                                    <option value="4">⭐⭐⭐⭐ - Great</option>
                                    <option value="3">⭐⭐⭐ - Good</option>
                                    <option value="2">⭐⭐ - Fair</option>
                                    <option value="1">⭐ - Poor</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Upload Photo (Optional)</label>
                                <div class="flex items-start gap-4 mb-4">
                                    <div id="preview_container" class="relative w-32 h-32 hidden">
                                        <img id="image_preview" src="#"
                                        class="w-full h-full object-cover rounded-lg border-2 border-gray-300">
                                    </div>
                                </div>
                                <input type="file" name="review_image" id="review_image_input" accept="image/jpeg,image/png"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                                @error('review_image')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-2">Accepted formats: JPG, PNG. Max 2MB.</p>
                            </div>
                        </div>

                        <!-- text and review area enter button -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Your Review</label>
                            <textarea name="review_text" id="review_textarea" rows="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Share your experience with this product...">{{old('review_text')}}</textarea>
                            @error('review_text')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-400 ml-auto">
                                <span id="char_count" class="transition-colors duration-200">0</span>/500 characters
                            </p>
                        </div>
                    </div>

                    <!-- cancelling and submitting -->
                    <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 sm:gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('profile.orders') }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                            Cancel
                        </a>
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-indigo-600 text-white font-bold rounded-md shadow hover:bg-indigo-700 transform transition active:scale-95">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</x-layout>

<x-footer></x-footer>

<script>
    //this is for the character counting
    //this is for the character counting
    const textarea = document.getElementById('review_textarea');
    const count = document.getElementById('char_count');

    function updateCharacterCount() {

        count.textContent = textarea.value.length;

        if(textarea.value.length >= 500) {
            count.classList.add('text-red-500');
        } else {
            count.classList.remove('text-red-500');
        }

    }

    updateCharacterCount(); //we will run it instantly so it knows what the current amount is as incase its loaded from the memory
    textarea.addEventListener('input', updateCharacterCount);

    //this is for temporarily viewing a uploaded image before its sent to the server
    document.getElementById('review_image_input').onchange = function (evt) {
    const [file] = this.files;
        if (file) {
            const preview = document.getElementById('image_preview');
            const container = document.getElementById('preview_container');

            //clean old preview if it exists
            if (preview.src.startsWith('blob:')) {
                URL.revokeObjectURL(preview.src);
            }
            //temporary image url
            preview.src = URL.createObjectURL(file);

            //makesure that you can view it
            container.classList.remove('hidden');
        }
    };

</script>
