<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ReturnOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    public function showReturnForm(Order $order, Product $product)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

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
            'reason' => 'required|string|max:255',
        ]);

        $order = Order::findOrFail($orderId);
        $item = $order->orderDetails()->where('product_id', $productId)->first();
        $quantityToReturn = $request->input('return_quantity');
        $alreadyReturned = ReturnOrder::where('order_id', $orderId)
            ->where('product_id', $productId)
            ->sum('return_quantity');

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (! $order->isReturnable()) {
            return redirect()->route('profile.orders.show', $orderId)->with('error', 'Only delivered orders can be returned.');
        }

        if ($request->return_quantity > ($item->quantity - $alreadyReturned)) {
            return back()->with('error', 'You cannot return more items than you currently possess.');
        }

        $returnOrder = ReturnOrder::create([
            'return_date' => now(),
            'reason' => $request->reason,
            'return_status' => 'Processing',
            'return_quantity' => $quantityToReturn,
            'product_id' => $productId,
            'order_id' => $orderId,
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $order->orderDetails()->where('product_id', $productId)->update(['delivery_status' => 'Pending Return']);
        $totalUnitsOrdered = $order->orderDetails->sum('quantity');
        $totalUnitsReturned = ReturnOrder::where('order_id', $orderId)->sum('return_quantity');

        if ($totalUnitsReturned >= $totalUnitsOrdered) {
            $order->update(['order_status' => 'Pending Full Return']);
            $returnOrder->update(['return_status' => 'Processing']);
            $message = 'Entire order is now pending full return.';
        } else {
            $order->update(['order_status' => 'Pending Partial Return']);
            $message = 'Item(s) added to return. Return request updated.';
        }

        return redirect()->route('profile.orders.show', $orderId)->with('success', $message);
    }

    public function returnEntireOrder(Request $request, $orderId)
    {
        $order = Order::with('orderDetails')->findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (! $order->isReturnable()) {
            return back()->with('error', 'Order cannot be returned.');
        }

        $createdAny = false;

        foreach ($order->orderDetails as $item) {
            $pendingQty = ReturnOrder::getPendingQty($order->id, $item->product_id);
            $returnedQty = ReturnOrder::getReturnedQty($order->id, $item->product_id);
            $remainingToReturn = $item->quantity - ($pendingQty + $returnedQty);

            if ($remainingToReturn > 0) {
                ReturnOrder::create([
                    'order_id' => $orderId,
                    'product_id' => $item->product_id,
                    'return_date' => now(),
                    'reason' => 'Full order return requested.',
                    'return_status' => 'Processing',
                    'user_id' => Auth::id(),
                    'return_quantity' => $remainingToReturn,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $item->update(['delivery_status' => 'Pending Return']);
                $createdAny = true;
            }
        }

        if (! $createdAny) {
            return back()->with('error', 'All items in this order are already pending or returned.');
        }

        $order->update(['order_status' => 'Pending Full Return']);

        return back()->with('success', 'Entire order marked for return.');
    }

    public function processReturn(Request $request, $orderId, $productId)
    {
        $request->validate([
            'reason' => 'required|string',
            'additional_details' => 'nullable|string|max:500',
        ]);

        $selectedReason = $request->input('reason');
        $details = $request->input('additional_details');
        $combinedReason = $details ? $selectedReason . ': ' . $details : $selectedReason;
        $request->merge(['reason' => $combinedReason]);

        return $this->returnSingleItem($request, $orderId, $productId);
    }

    public function cancel(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        if (! $order->isCancellable()) {
            return back()->with('error', 'This order cannot be cancelled as it is already being processed.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['order_status' => 'Refunded']);

            foreach ($order->orderDetails()->with('product')->get() as $item) {
                if ($item->product) {
                    $item->product->increment('product_stock', $item->quantity);
                }
            }
        });

        return back()->with('success', 'Order #' . $order->id . ' was cancelled and refunded.');
    }

    public function cancelPendingReturn(ReturnOrder $return)
    {
        if (Auth::id() !== $return->user_id) {
            abort(403);
        }

        if ($return->return_status !== 'Processing') {
            return back()->with('error', 'This return has already been processed and cannot be cancelled.');
        }

        DB::transaction(function () use ($return) {
            $order = $return->order;
            $productId = $return->product_id;

            $return->delete();

            //reset item back to delivered after cancel
            $order->orderDetails()->where('product_id', $productId)->update(['delivery_status' => 'Delivered']);
            $this->syncOrderStatus($order);
        });

        $remainingReturnsCount = ReturnOrder::where('order_id', $return->order->id)->count();

        if ($remainingReturnsCount === 0) {
            $return->order->update([
                'order_status' => 'Delivered',
            ]);
        }

        return back()->with('success', 'Return request has been cancelled.');
    }

    public function approveReturn(ReturnOrder $returnOrder)
    {
        DB::transaction(function () use ($returnOrder) {
            if (! $returnOrder->stock_restored) {
                $returnOrder->product->increment('product_stock', $returnOrder->return_quantity);
            }

            $returnOrder->update([
                'return_status' => 'Approved',
                'admin_processed_at' => now(),
                'stock_restored' => true,
            ]);

            $returnOrder->order->orderDetails()->where('product_id', $returnOrder->product_id)->update(['delivery_status' => 'Returned']);
            $this->syncOrderStatus($returnOrder->order);
        });

        return back()->with('success', 'Return approved and stock updated.');
    }

    private function syncOrderStatus(Order $order)
    {
        $totalOrdered = $order->orderDetails()->sum('quantity');
        $totalReturned = $order->returns()
            ->where('return_status', 'Approved')
            ->sum('return_quantity');
        $totalPending = $order->returns()
            ->where('return_status', 'Processing')
            ->sum('return_quantity');

        if ($totalReturned >= $totalOrdered) {
            $order->update(['order_status' => 'Fully Returned']);
            return;
        }

        if (($totalPending + $totalReturned) >= $totalOrdered) {
            $order->update(['order_status' => 'Pending Full Return']);
            return;
        }

        if ($totalPending > 0) {
            $order->update(['order_status' => 'Pending Partial Return']);
            return;
        }

        if ($totalReturned > 0) {
            $order->update(['order_status' => 'Partially Returned']);
            return;
        }

        $order->update(['order_status' => 'Delivered']);
    }
}

