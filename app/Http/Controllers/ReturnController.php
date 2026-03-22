<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ReturnOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{

    public function showReturnForm(Order $order, Product $product)
    {
        if ($order->user_id !== Auth::id()) abort(403);

        $item = $order->orderDetails()->where('product_id', $product->id)->firstOrFail();

        $pendingQty = ReturnOrder::getPendingQty($order->id, $product->id);
        $returnedQty = ReturnOrder::getReturnedQty($order->id, $product->id);
        $maxQuantity = $item->quantity - ($pendingQty + $returnedQty);

        return view('returns', compact('order', 'product', 'maxQuantity'));
    }

    public function returnSingleItem(Request $request, $orderId, $productId)
    {

        $request->validate([
            'return_quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255'
        ]);



        //locates the order this return is linked to
        $order = Order::findOrFail($orderId);
        $item = $order->orderDetails()->where('product_id', $productId)->first();
        $quantityToReturn = $request->input('return_quantity');

        $alreadyReturned = ReturnOrder::where('order_id', $orderId)->where('product_id', $productId) ->sum('return_quantity');

        //make sure the order belongs to the user
        if ($order->user_id !== Auth::id()) abort(403);

        //makes sure order is returnable (if its been delivered)
        if (!$order->isReturnable()) {
            return redirect()->route('profile.orders.show', $orderId)->with('error', 'Only delivered orders can be returned.');
        }

        //make sure returning quantity doesnt exceed the product stock
        if ($request->return_quantity > ($item->quantity - $alreadyReturned)) {
        return back()->with('error', 'You cannot return more items than you currently possess.');
        }

        $returnOrder = ReturnOrder::create([
            'return_date' => now(),
            'reason' => $request->reason,
            'return_status' => 'Pending Return',
            'return_quantity' => $quantityToReturn,
            'product_id' => $productId,
            'order_id' => $orderId,
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //update the items delivery status to pending return
        $item->update(['delivery_status' => 'Pending Return']);

        //because its only one item, we dont update order status until all items are return requested
        //sum of everything originally bought
        $totalUnitsOrdered = $order->orderDetails->sum('quantity');

        //sum of everything currently being returned (across all products in this order)
        $totalUnitsReturned = ReturnOrder::where('order_id', $orderId)->sum('return_quantity');

        if ($totalUnitsReturned >= $totalUnitsOrdered) {
            //every single item is coming back from the order
            $order->update(['order_status' => 'Pending Full Return']);
            //returnOrders will not have a status like normalOrders (no specifying pending)
            $returnOrder->update(['return_status' => 'Pending Return']);
            $message = 'Entire order is now pending full return.';
        } else {
            //user is still holding onto some items
            $order->update(['order_status' => 'Pending Partial Return']);
            $message = 'Item(s) added to return. Return request updated.';
        }


        return redirect()->route('profile.orders.show', $orderId)->with('success', $message);
    }

    public function returnEntireOrder(Request $request, $orderId)
    {
        $order = Order::with('orderDetails')->findOrFail($orderId);

        if ($order->user_id !== Auth::id()) abort(403);

        if (!$order->isReturnable()) {
            return back()->with('error', 'Order cannot be returned.');
        }

        $createdAny = false;

        //create return records for EVERY item in the order
        foreach ($order->orderDetails as $item) {
            $pendingQty = ReturnOrder::getPendingQty($order->id, $item->product_id);
            $returnedQty = ReturnOrder::getReturnedQty($order->id, $item->product_id);

            //calculate what hasn't been touched yet
            $remainingToReturn = $item->quantity - ($pendingQty + $returnedQty);
            //only create if one doesn't already exist for this item
            if ($remainingToReturn > 0) {
            ReturnOrder::Create([
                    'order_id' => $orderId,
                    'product_id' => $item->product_id,
                    'return_date' => now(),
                    'reason' => 'Full order return requested.',
                    'return_status' => 'Pending Return',
                    'user_id' => Auth::id(),
                    'return_quantity' => $remainingToReturn,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            //update each item to pending return
            $item->update(['delivery_status' => 'Pending Return']);
            $createdAny = true;
        }
        }

        if (!$createdAny) {
        return back()->with('error', 'All items in this order are already pending or returned.');
        }

        //update the main order status
        $order->update(['order_status' => 'Pending Full Return']);
        return back()->with('success', 'Entire order marked for return.');
    }

    public function processReturn(Request $request, $orderId, $productId)
    {

        //make sure a reason was selected
        $request->validate([
            'reason' => 'required|string',
            'additional_details' => 'nullable|string|max:500'
        ]);

        $selectedReason = $request->input('reason');
        $details = $request->input('additional_details');

        //if there are details, combine ther just use the selected reason
        $combinedReason = $details ? $selectedReason . ': ' . $details  : $selectedReason;
        $request->merge(['reason' => $combinedReason]);
        return $this->returnSingleItem($request, $orderId, $productId);
    }

    public function cancel(Order $order)
    {
        //ensure the user owns the order and it's actually pending (not shipped or delivered to cancel)
        if (Auth::id() !== $order->user_id && $order->order_status == 'Placed') {
            abort(403);
        }

        if (!$order->isCancellable()) {
            return back()->with('error', 'This order cannot be cancelled as it is already being processed.');
        }

      DB::transaction(function () use ($order) {
            //updates the order status
            $order->update(['order_status' => 'Cancelled']);

            //loop through the order items and put them back into stock making sure its the right one
            foreach ($order->orderDetails()->with('product')->get() as $item) {
                if ($item->product) {
                    $item->product->increment('product_stock', $item->quantity);
                }
            }
        });

        $this->syncOrderStatus($order);

        return back()->with('success', 'Order #'. $order->id .' has been cancelled.');
    }

    public function cancelPendingReturn(ReturnOrder $return)
    {
        //make sure the return belongs to the user
        if (Auth::id() !== $return->user_id && $return->order->order_status == 'Placed') {
            abort(403);
        }

        //double check that it is still in a 'Pending' state before deleting
        if (!str_contains($return->return_status, 'Pending')) {
            return back()->with('error', 'This return has already been processed and cannot be cancelled.');
        }

        $orderItem = OrderDetail::where('order_id', $return->order_id)->where('product_id', $return->product_id)->first();

        if ($orderItem) {
            $orderItem->update(['delivery_status' => 'Delivered']);
        }

        $return->delete();

        $remainingReturnsCount = \App\Models\ReturnOrder::where('order_id', $return->order->id)->count();

        if ($remainingReturnsCount === 0) {
            //if there are returns are left at all, revert the order status
            $return->order->update([
                'order_status' => 'Delivered'
            ]);
        }

        return back()->with('success', 'Return request has been cancelled.');
    }

    public function approveReturn(ReturnOrder $returnOrder)
    {
        DB::transaction(function () use ($returnOrder) {
            $returnOrder->update(['return_status' => 'Returned']);

            $orderItem = OrderDetail::where('order_id', $returnOrder->order_id)->where('product_id', $returnOrder->product_id)->first();

            if ($orderItem) {
                $orderItem->update(['delivery_status' => 'Returned']);
            }

            //put the specific returned quantity back into stock
            $returnOrder->product->increment('product_stock', $returnOrder->return_quantity);
            $this->syncOrderStatus($returnOrder->order);

        });

        return back()->with('success', 'Return approved and stock updated.');
    }

    private function syncOrderStatus(Order $order)
    {
        //calculate total units ordered
        $totalOrdered = $order->orderDetails()->sum('quantity');

        //caclulate returned orders that have been approved to return // set it to returned
        $totalReturned = $order->returns()
            ->where('return_status', 'Returned')
            ->sum('return_quantity');

        //calculate returned orders that are still either pending full/partial returns
        $totalPending = $order->returns()
            ->where('return_status', 'like', 'Pending%')
            ->sum('return_quantity');

        //update the order status
        if ($totalReturned >= $totalOrdered) {
            //if all the order details (products) are returned
            $order->update(['order_status' => 'Fully Returned']);
            return;
        }

        if (($totalPending + $totalReturned) >= $totalOrdered) {
            //if all the products are awaiting return
            $order->update(['order_status' => 'Pending Full Return']);
            return;
        }
        if ($totalPending > 0) {
            //if any products are pending return (not all of them from before checks) then it is partial pending
            $order->update(['order_status' => 'Pending Partial Return']);
            return;
        }
        if ($totalReturned > 0) {
            //if anything is pending or some is returned it is at least a Partial Return
            $order->update(['order_status' => 'Partially Returned']);
            return;
        }

        //otherwise status should be set to delivered as there are no returns (return requests could be cancelled)
        $order->update(['order_status' => 'Delivered']);
    }
}
