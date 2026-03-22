<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ReturnOrder;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReturnOrderSeeder extends Seeder
{
    public function run(): void
    {

        $order = Order::findOrFail(3);

        DB::table('return_orders')->insert([
            'order_id' => 3,
            'product_id' => 3,
            'user_id' => 2,
            'return_date' => now(),
            'reason' => 'Item arrived with a slight scratch on the casing.',
            'return_status' => 'Pending Full Return',
            'return_quantity' => 1,
            'stock_restored' => false, //stock not updated yet
            'created_at' => now(),
            'updated_at'=>now()
        ]);
        OrderDetail::where('order_id', 3)->where('product_id', 3)->update(['delivery_status' => 'Pending Return']);

        $order->update(['order_status' => 'Pending Full Return']);

        $this->command->info('Seeded a Delivered order with 1 item pending return.');


        // created one pending full return order
        $order = Order::with('orderDetails')->findOrFail(10);

        foreach ($order->orderDetails as $item) {
            ReturnOrder::create([
                'order_id'        => $order->id,
                'product_id'      => $item->product_id,
                'user_id'         => $order->user_id,
                'return_date'     => now(),
                'reason'          => 'Changed my mind.',
                'return_status'   => 'Pending Return',
                'return_quantity' => $item->quantity,
                'stock_restored'  => false,
                'created_at'     => now(),
            ]);

            $item->update(['delivery_status' => 'Pending Return']);
        }
        $order->update(['order_status' => 'Pending Full Return']);

        // created one full return order
        $order = Order::with('orderDetails')->findOrFail(11);

        foreach ($order->orderDetails as $item) {
            ReturnOrder::create([
                'order_id'        => $order->id,
                'product_id'      => $item->product_id,
                'user_id'         => $order->user_id,
                'return_date'     => now(),
                'reason'          => 'Changed my mind.',
                'return_status'   => 'Returned',
                'return_quantity' => $item->quantity,
                'stock_restored'  => false,
                'created_at'     => now(),
            ]);
            $item->update(['delivery_status' => 'Returned']);
        }
        $order->update(['order_status' => 'Fully Returned']);

        $this->command->info('Created two full return orders (one pending one complete).');

        //attempt to create two partially returned orders
        $partialOrder = Order::with('orderDetails')->findOrFail(7);
        $itemToReturn = $partialOrder->orderDetails->first();
        $totalItemsInOrder = $partialOrder->orderDetails->count();

        //there was error with logic when it changed status of an order with only one product
        // so we check if there are other items in the order.
        $qtyToReturn = ($itemToReturn->quantity > 1) ? 1 : $itemToReturn->quantity;
        $status = ($totalItemsInOrder > 1 || $itemToReturn->quantity > $qtyToReturn) ? 'Partially Returned' : 'Fully Returned';

        ReturnOrder::create([
            'order_id'        => $partialOrder->id,
            'product_id'      => $itemToReturn->product_id,
            'user_id'         => $partialOrder->user_id,
            'return_date'     => now(),
            'reason'          => 'Technical fault found after 2 days.',
            'return_status'   => 'Returned',
            'return_quantity' => $qtyToReturn,
            'stock_restored'  => true,
            'created_at'      => now(),
        ]);

        $itemToReturn->update(['delivery_status' => 'Returned']);

        $partialOrder->update(['order_status' => $status]);

        $partialOrder = Order::with('orderDetails')->findOrFail(8);
        $itemToReturn = $partialOrder->orderDetails->first();
        $totalItemsInOrder = $partialOrder->orderDetails->count();

        //there was error with logic when it changed status of an order with only one product
        //so we check if there are other items in the order.
        $qtyToReturn = ($itemToReturn->quantity > 1) ? 1 : $itemToReturn->quantity;
        $status = ($totalItemsInOrder > 1 || $itemToReturn->quantity > $qtyToReturn) ? 'Partially Returned' : 'Fully Returned';

        ReturnOrder::create([
            'order_id'        => $partialOrder->id,
            'product_id'      => $itemToReturn->product_id,
            'user_id'         => $partialOrder->user_id,
            'return_date'     => now(),
            'reason'          => 'Technical fault found after 2 days.',
            'return_status'   => 'Returned',
            'return_quantity' => $qtyToReturn,
            'stock_restored'  => true,
            'created_at'      => now(),
        ]);

        $itemToReturn->update(['delivery_status' => 'Returned']);

        $partialOrder->update(['order_status' => $status]);


         $this->command->info('Attempted to create two partially returned orders.');

    }
}
