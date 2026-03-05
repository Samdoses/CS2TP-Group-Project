<x-header></x-header>

<x-layout>
<div class="bg-gray-100 min-h-screen flex flex-col">

<div class="container mx-auto px-6 ">
<br>
<!-- title of the page -->
<h1 class="text-3xl font-extrabold text-gray-800 mb-4 text-center">Your Order Details</h1>

<div class="flex justify-between items-center mb-8">
    <!-- on the left its order number -->
    <p class="text-gray-700 font-semibold text-xl">Order #{{$order->id}}</p>
    <!-- the middle its the date of the order -->
    <p class="text-gray-600 text-semibold text-xl">Placed on {{$order->order_date->format('M d, Y')}}</p>
    <!-- on the right its status, for now only blue but when admin is done will change colours-->
    <span class="px-6 py-1.5 rounded-lg text-lg font-semibold {{$order->getColourStatus()}}"> {{ $order->order_status}} </span>
</div>

<!-- handle errors and success messages -->
    @if (session('error'))
        <div class="mx-auto mb-6">
            <div class="rounded-lg border-l-4 border-red-500 bg-red-100 p-4 text-red-700 shadow-sm" role="alert">
                <p class="font-bold">Error</p>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif
    @if (session('success'))
        <div class="mx-auto mb-6">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif
<!-- box for all order items -->
<div class="lg:col-span-2 space-y-6 mb-8">
    <!-- example of a ordered item -->
    @foreach ($order->orderDetails as $item)
    <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col md:flex-row items-start gap-6 border border-gray-200">
        <div class="flex-shrink-0">
            <!-- the image of the item-->
            <img src="{{$item->product->product_image}}" alt="Item" class="w-24 h-24 object-cover rounded-lg shadow-sm">
        </div>
        <div class="flex-1 min-w-0">
              <!-- shows the item name -->
            <a href="/product/{{$item->product->id}}" class="text-xl font-bold text-gray-800 mb-1">{{ $item->product->product_name ?? 'Product removed from sale' }}</a>
              <!-- show the model of the item -->
            <p class="text-sm text-gray-500 mb-3">Model: {{ $item->product->product_model }}</p>
            <p class="text-sm text-gray-700 mb-3">Colour: {{ $item->product->product_colour }}</p>

        </div>

        <div class="flex flex-col items-end md:items-center gap-2 md:gap-4 md:w-40">
              <!-- shows the price of this item -->
            <div class="font-bold text-lg text-gray-800">£{{number_format($item->order_price, 2)}}</div>
              <!-- shows the quantity of this item -->
            <div class="px-3 py-1 border border-gray-300 rounded-lg text-center font-semibold text-gray-700"> Quantity: {{$item->quantity}}
            </div>


        @if($order->order_status === 'Delivered')
            @php
                //find and check if a review already exists for this item in this order
                $existingReview = \App\Models\Review::where('order_id', $order->id)->where('product_id', $item->product_id)->first();
            @endphp
            @if($existingReview)
            <!--if a review exists show view the review -->
            <a href="{{ route('reviews.image.show', $existingReview->id) }}"
               class="font-bold text-green-600 hover:text-green-800 transition">
                    View Your Review
                </a>
            @else
                <!-- if no review exists show write a review -->
                <a href="{{ route('reviews.create', [$order->id, $item->product->id]) }}"
                class="font-bold text-indigo-500 hover:text-indigo-700 transition">
                    Write a Review
                </a>
            @endif
        @endif

        </div>


    </div>
    @endforeach
</div>


<!-- box for the order details and order summary -->
<div class="flex flex-col md:flex-row gap-6 mb-8">

    <!-- the order details box -->
    <div class="flex-1 bg-white p-6 rounded-xl shadow-lg border border-gray-200">
        <!-- the heading for the box -->
        <h2 class="text-2xl font-bold mb-4 text-gray-800 mb-4 text-center">Order Details</h2>

        <!-- showing customer details -->
        <p class="text-lg mb-2"><span class="font-semibold">Name:</span> {{$order->user->first_name . " " .$order->user->last_name}}</p>
        <p class="text-lg mb-2"><span class="font-semibold">Email:</span> {{$order->user->email}} </p>
        <p class="text-lg mb-2"><span class="font-semibold">Shipping Address:</span> {{$order->order_address}}</p>
    </div>

    <!-- the order summary box -->
    <div class="flex-1 bg-white p-6 rounded-xl shadow-lg border border-gray-200">
        <!-- the heading for the box -->
        <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Order Summary</h2>


        <!-- Showing the prices of the order -->

        @php
            //calculating the price of the shipping from the delivery method selected
            $shippingCost= [
                'standard' => 3.95,
                'express' => 6.95
            ]
        @endphp

        <p class="text-lg mb-2"><span class="font-semibold">Subtotal:</span> £{{number_format(($order->total_price) - ($shippingCost[$order->delivery_method]) , 2)}}</p>

        <p class="text-lg mb-2"><span class="font-semibold">Delivery Charges:</span> {{ucfirst($order->delivery_method)}} Delivery (£{{number_format($shippingCost[$order->delivery_method], 2)}})</p>

        <p class="text-lg mb-2"><span class="font-semibold">Grand Total:</span> £{{number_format($order->total_price, 2)}}</p>
    </div>

</div>



</div>
</div>
</x-layout>
<x-footer></x-footer>
