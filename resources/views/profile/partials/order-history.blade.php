<h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">Order History</h2>

@if($orders->isEmpty())
    <div class="text-center py-10 text-gray-500">
        <p>You haven't placed any orders yet.</p>
        <a href="{{ route('store.index') }}" class="text-indigo-600 hover:underline mt-2 inline-block">Start Shopping</a>
    </div>
@else
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-semibold">
                    <th class="py-3 px-4">Order ID</th>
                    <th class="py-3 px-4">Date</th>
                    <th class="py-3 px-4">Time</th>
                    <th class="py-3 px-8">Status</th>
                    <th class="py-3 px-4 text-right">Total</th>
                    <th class="py-3 px-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach($orders as $order)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 font-medium text-gray-900">#{{ $order->id }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $order->order_date->format('M d, Y') }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $order->order_date->format('H:i') }}</td>
                        <td class="py-3 px-7">
                            <span class="px-1.5 py-1 rounded-full text-xs font-semibold
                                {{ $order->getColourStatus() }}">
                                {{ $order->order_status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right font-medium">£{{ number_format($order->total_price, 2) }}</td>
                        <td class="py-3 px-4 text-right">
                            <a href="{{ route('profile.orders.show', $order->id)}}" class="text-indigo-600 hover:text-indigo-900 font-medium">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
@endif

