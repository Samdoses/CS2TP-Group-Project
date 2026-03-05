<x-header></x-header>
<x-layout>
    <div class="max-w-2xl mx-auto px-4 py-12">
        <div class="bg-white p8 md:p-12 rounded-xl border border-gray-100 shadow-2xl">
        <h1 class="text-3xl font-bold mb-6 text-gray-900">Contact Us</h1>
        <p class="text-gray-600 mb-8">
            Have a question or need help with a build? Send us a message below!
        </p>

        <form action="/contact" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                <input
                    type="text"
                    name="subject"
                    id="subject"
                    required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 p-2 border"
                    placeholder="What is this regarding?"
                >
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea
                    name="message"
                    id="message"
                    rows="5"
                    required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 p-2 border"
                    placeholder="How can we help you today?"
                ></textarea>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Send Message
                </button>
            </div>

            @if (session('status'))
                <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('status') }}
                </div>
            @endif
        </form>
    </div> </div>
</x-layout>

<x-footer></x-footer>
