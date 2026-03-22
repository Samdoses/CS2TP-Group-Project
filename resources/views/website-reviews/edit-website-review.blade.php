<x-header></x-header>
<x-layout>
    <div class="max-w-2xl mx-auto py-10 sm:py-20 px-4">
        <h1 class="text-2xl font-bold mb-6">Edit Your Review</h1>

        <form action="{{ route('website-reviews.update', $websiteReview) }}" method="POST" class="bg-white p-5 sm:p-8 rounded-xl shadow">
            @csrf
            @method('PUT')

            <label class="block mb-2 font-medium">Rating</label>
            <select name="rating" class="w-full mb-6 border rounded-lg p-2">
                @for($i=1; $i<=5; $i++)
                    <option value="{{ $i }}" {{ $websiteReview->rating == $i ? 'selected' : '' }}>{{ $i }} Stars</option>
                @endfor
            </select>

            <label class="block mb-2 font-medium">Your Feedback</label>
            <textarea name="review_text" rows="5" class="w-full mb-6 border rounded-lg p-2">{{ $websiteReview->review_text }}</textarea>

            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
                <a href="/" class="text-gray-500 py-2">Back to Home</a>
                <button type="submit" class="w-full sm:w-auto bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold">Update Review</button>
            </div>
        </form>
    </div>
</x-layout>
<x-footer></x-footer>
