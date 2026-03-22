<x-header></x-header>

<x-layout>
<div class="bg-gray-100 min-h-screen flex flex-col">

<div class="container mx-auto px-6 ">
<br>
<!-- title of the page -->
<h1 class="text-3xl font-extrabold text-gray-800 mb-4 text-center">Your Order Details</h1>

<div class="flex justify-between items-center mb-8 gap-4">
    <!-- on the left its order number -->
    <div class="flex items-center gap-3">
        <p class="text-gray-700 font-semibold text-xl">Order #{{$order->id}}</p>
        <div class="text-gray-600 text-semibold text-xl">Placed on {{$order->order_date->format('M d, Y')}}</div>
    </div>
        <!-- on the right its status, for now only blue but when admin is done will change colours-->
    <div class="flex items-center gap-3">
        <span class="px-4 py-2 rounded-lg text-sm font-bold shadow-sm {{ $order->getColourStatus() }}">
            {{ $order->order_status }}
        </span>

        @if($returns->count() > 0)
            <button onclick="document.getElementById('returnTable').classList.remove('hidden')"
                    class="px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg text-sm font-bold hover:bg-indigo-100 transition shadow-sm whitespace-nowrap">
                View Return Status ({{ $returns->count() }})
            </button>
        @endif
    </div>
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
    @php
        $pendingQty = \App\Models\ReturnOrder::getPendingQty($order->id, $item->product_id);
        $returnedQty = \App\Models\ReturnOrder::getReturnedQty($order->id, $item->product_id);

        //checks that the items are either returned or waiting for approval
        $isFaded = (($pendingQty + $returnedQty) >= $item->quantity);
        //item is only gone if the confirmed returns match the quantity
        $isOfficiallyReturned = ($returnedQty >= $item->quantity);
        //calculates what can still be actioned (remaining to be returned)
        $remainingToReturn = $item->quantity - ($pendingQty + $returnedQty);

    @endphp
    <!-- if all the quantity items arent being returned, then it will look normal -->
    <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col md:flex-row items-center md:items-stretch gap-6 border border-gray-200 transition-all duration-300
        {{ $isFaded ? 'opacity-60 bg-gray-50 border-dashed' : '' }}">

        <div class="flex-shrink-0 relative w-24 h-24">
            <img src="{{$item->product->product_image}}" alt="Item" class="w-full h-full object-cover rounded-lg shadow-sm {{ $isOfficiallyReturned ? 'sepia-[.5]' : '' }}">
                @if($isOfficiallyReturned)
                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-10 rounded-lg">
                        <span class="text-white text-[10px] font-black uppercase tracking-widest bg-red-600 px-2 py-1 rounded shadow">Returned</span>
                    </div>
                @elseif(in_array($order->order_status, ['Cancelled', 'Refunded'], true))
                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-20 rounded-lg">
                        <span class="text-white text-[10px] font-black uppercase tracking-widest bg-gray-700 px-2 py-1 rounded shadow">{{ $order->order_status }}</span>
                    </div>
                @endif
        </div>

        <div class="flex-1 min-w-0 flex flex-col justify-center">
              <!-- shows the item name -->
            <a href="/product/{{$item->product->id}}"
                class="text-xl font-bold mb-1 block {{ $isFaded ? 'line-through text-gray-500' : 'text-gray-800' }}">{{ $item->product->product_name ?? 'Product removed from sale' }}</a>
              <!-- show the model of the item -->
            <p class="text-sm text-gray-500 {{ $isFaded ? 'line-through' : '' }}">Model: {{ $item->product->product_model }}</p>
            <p class="text-sm text-gray-700 {{ $isFaded ? 'line-through' : '' }}">Colour: {{ $item->product->product_colour }}</p>

        </div>

        <div class="w-full md:w-56 flex flex-col justify-between items-end gap-3 border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6">
            <div class="w-full flex flex-col items-center gap-1">
            <!-- shows the price of this item -->
            <div class="font-bold text-lg text-center text-gray-800 {{ $isFaded ? 'line-through' : '' }}">£{{number_format($item->order_price, 2)}}</div>
              <!-- shows the quantity of this item -->
            <div class="px-3 py-1 border border-gray-300 rounded-lg text-center font-semibold text-gray-700"> Quantity: {{$item->quantity}}</div>
            </div>

            <div class="w-full space-y-2">
            @if($order->order_status === 'Delivered')
                @php
                    //find and check if a review already exists for this item in this order
                    $existingReview = \App\Models\Review::where('order_id', $order->id)->where('product_id', $item->product_id)->first();

                @endphp
                    <div class="text-center">
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
                    </div>
            @endif

            @if ($order->isReturnable())
                @php
                    //calculates if there is still quantity within a product that you can return
                    $totalReturnedForThisItem = \App\Models\ReturnOrder::where('order_id', $order->id)
                    ->where('product_id', $item->product_id)
                    ->whereIn('return_status', ['Processing', 'Approved'])
                    ->sum('return_quantity');


                    //calculates the amount of quantity within the product that is pending return or completed return
                    $remainingQty = $item->quantity - $totalReturnedForThisItem;


                    //calculates what can still be actioned (remaining to be returned)
                    $remainingToReturn = $item->quantity - ($pendingQty + $returnedQty);

                @endphp
                    <div class="w-full space-y-2">
                        @if($remainingToReturn > 0)
                            <!-- return product page visible when there are products u can till return -->
                            <a href="{{ route('orders.return.item', [$order->id, $item->product_id]) }}"
                            class="w-full block text-center text-red-500 font-bold rounded-lg hover:bg-red-500 hover:text-white transition-all duration-200">
                                Return Item
                            </a>
                        @endif
                        <!-- displays a message only when there is already some quantity of product pending/completed return-->
                       <div class="space-y-1">
                        @if($remainingToReturn <= 0)
                            <!-- can put smth here later to show every quantity has been either partially or fully returned
                                can also do a statement to ($isOfficiallyReturned) to check if the entire order is fully returned-->
                        @endif

                        @if($returnedQty > 0)
                            <span class="px-3 py-1 w-full block text-center bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200">
                                {{ $returnedQty }} approved return
                            </span>
                        @endif

                        @if($pendingQty > 0)
                            <span class="px-3 py-1 w-full block text-center bg-orange-100 text-orange-600 rounded-full text-xs font-bold border border-orange-200">
                                {{ $pendingQty }} processing return
                            </span>
                        @endif
                       </div>

                    </div>

            @endif
        </div>
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

<div>
    @if($order->isReturnable())
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200 flex justify-between items-center">
                <div>
                    <h4 class="font-bold text-gray-800">Need to return everything?</h4>
                    <p class="text-sm text-gray-600">This will request a return for all items in Order #{{ $order->id }}. No questions asked!</p>
                </div>
                <form action="{{ route('orders.return.all', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded font-bold hover:bg-red-700 transition"
                            onclick="return confirm('Are you sure you want to return the entire order?')">
                        Return Entire Order
                    </button>
                </form>
            </div>
    @endif
    @if($order->isCancellable())
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200 flex justify-between items-center">
             <div>
                <h4 class="font-bold text-gray-800">Changed your mind?</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">This will cancel your entire order.</p>
            </div>
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded font-bold hover:bg-red-700 transition"
                        onclick="return confirm('Are you sure you want to cancel this order?')">
                    Cancel Order
                </button>
            </form>
        </div>
    @endif
</div>


</div>

<div id="returnTable" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" onclick="document.getElementById('returnTable').classList.add('hidden')"></div>

        <div class="inline-block align-middle bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-6 py-6">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h3 class="text-2xl font-bold text-gray-800">Return History</h3>
                    <button onclick="document.getElementById('returnTable').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-3xl leading-none">&times;</button>
                </div>

                <div class="divide-y divide-gray-100 max-h-[400px] overflow-y-auto border border-t-0 rounded-b-lg shadow-inner custom-scrollbar">
                    <div class="space-y-4">
                        @foreach($returns as $return)
                        <div class="flex items-center gap-4 p-4 border rounded-xl bg-gray-50">
                            <div class="grid grid-cols-12 items-center gap-4 p-4 border border-gray-200 rounded-xl bg-gray-50 shadow-sm">
                            <div class="col-span-6 flex items-center gap-3">
                                <img src="{{ $return->product->product_image }}" class="w-16 h-16 object-cover rounded-lg">
                                <div class="min-w-0">
                                    <h4 class="font-bold text-gray-800 text-sm">{{ $return->product->product_name }}</h4>
                                    <p class="text-[10px] text-gray-400">{{ $return->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="col-span-2 text-center">
                                <span class="inline-block px-2.5 py-1 bg-gray-100 rounded-md text-xs font-bold text-gray-700 border border-gray-200">
                                    {{ $return->return_quantity }}
                                </span>
                            </div>
                            <div class="col-span-4 text-right">
                                <span class="inline-block px-2 py-1 rounded-md text-[10px] font-bold mb-1
                                    {{ str_contains($return->return_status, 'Pending') ? 'bg-orange-100 text-orange-600' : 'bg-green-100 text-green-700' }}">
                                    {{ $return->return_status }}
                                </span>

                                @if(str_contains($return->return_status, 'Pending'))
                                    <form action="{{ route('orders.return.cancel', $return->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this return request?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[10px] font-bold text-red-500 hover:text-red-700 underline transition">
                                            Cancel Return
                                        </button>
                                    </form>
                                @endif
                                <div class="col-span-12 pt-2 border-t border-gray-100">
                                    <p class="text-xs text-gray-500 italic truncate">"{{ $return->reason }}"</p>
                                    @if($return->admin_comment)
                                        <p class="mt-1 text-xs text-gray-600">Admin comment: {{ $return->admin_comment }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                <p class="text-xs text-gray-400 italic">Scroll for more items if applicable</p>
                <button type="button" onclick="document.getElementById('returnTable').classList.add('hidden')"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-md">
                    Close History
                </button>
            </div>
        </div>
    </div>
</div>
</x-layout>
<x-footer></x-footer>


