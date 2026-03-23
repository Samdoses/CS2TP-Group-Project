<x-header></x-header>
<x-layout>
    
<section class="flex items-center bg-gray-100 py-16">
    <main class="container mx-auto max-w-3xl px-4">
        <div class="relative bg-white rounded-2xl shadow-xl p-10 text-center border border-gray-200">

            <!-- confirmation title -->
             <h1 class= "text-4xl md:text-5xl font-bold text-gray-800 mt-4 mb-4">
                Thank you for your order!
            </h1>
            <!-- smaller text explaination-->
            <p class="text-gray-600 text-lg leading-relaxed max-w-xl mx-auto mb-6">
                Your payment has been successfully processed. A confirmation email has been sent to your inbox with your order details.
            </p>

            <!--order price -->
            @if(session('order_total'))
            <p><strong> Total Paid: </strong> £{{ number_format(session('order_total'), 2) }}</p>
            @endif

            <br>

        <!-- the back to store button -->
         <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href= "{{route('store.index')}}" class= "rounded-lg border border-gray-300 bg-white px-6 py-3 text-lg font-bold text-grey-700 shadow-sm transition hover:bg-gray-100">
            Continue Shopping  
        </a>

        <!-- the order history button -->
         <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href= "{{route('profile.orders')}}" class= "block w-full rounded-lg bg-indigo-600 p-3 text-center text-lg font-bold text-white shadow-lg transition duration-200 hover:bg-indigo-700">
            View Order History
        </a>

</div>
</div>
</main>
</section>
</x-layout>
<x-footer></x-footer>

