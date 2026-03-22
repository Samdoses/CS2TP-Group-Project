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

        //PENDING FULL RETURN REQUEST FOR ONE ITEM
        $order1 = Order::findOrFail(3);

        DB::table('return_orders')->insert([
            'order_id' => 3,
            'product_id' => 3,
            'user_id' => 2,
            'return_date' => now(),
            'reason' => 'Item arrived with a slight scratch on the casing.',
            'return_status' => 'Processing',
            'return_quantity' => 1,
            'stock_restored' => false, //stock not updated yet
            'created_at' => now(),
            'updated_at'=>now()
        ]);

        $order1->update(['order_status' => 'Pending Full Return']);
        OrderDetail::where('order_id', 3)->where('product_id', 3)->update(['delivery_status' => 'Pending Return']);

        $this->command->info('Seeded a Delivered order with 1 item pending return.');


        //PENDING FULL RETURN ORDER WITH MULTIPLE ITEMS
        // created one pending full return order
        $order2 = Order::with('orderDetails')->findOrFail(10);

        foreach ($order2->orderDetails as $item) {
            ReturnOrder::create([
                'order_id'        => $order2->id,
                'product_id'      => $item->product_id,
                'user_id'         => $order2->user_id,
                'return_date'     => now(),
                'reason'          => 'Changed my mind.',
                'return_status'   => 'Processing',
                'return_quantity' => $item->quantity,
                'stock_restored'  => false,
                'created_at'     => now(),
            ]);
        }
        $order2->update(['order_status' => 'Pending Full Return']);
        $order2->orderDetails()->update(['delivery_status' => 'Pending Return']);

        //FULLY RETURNED ORDER
        // created one full return order
        $order3 = Order::with('orderDetails')->findOrFail(11);

        foreach ($order3->orderDetails as $item) {
            ReturnOrder::create([
                'order_id'        => $order3->id,
                'product_id'      => $item->product_id,
                'user_id'         => $order3->user_id,
                'return_date'     => now(),
                'reason'          => 'Changed my mind.',
                'return_status'   => 'Approved',
                'return_quantity' => $item->quantity,
                'stock_restored'  => false,
                'created_at'     => now(),
            ]);
        }
        $order3->update(['order_status' => 'Fully Returned']);
        $order3->orderDetails()->update(['delivery_status' => 'Returned']);

        $this->command->info('Created two full return orders (one pending one complete).');


        //attempt to create two partially returned orders
        //PARTIALLY RETURNED ORDER
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
            'return_status'   => 'Approved',
            'return_quantity' => $qtyToReturn,
            'stock_restored'  => true,
            'created_at'      => now(),
        ]);

        $partialOrder->update(['order_status' => $status]);
        DB::table('order_details')->where('order_id', $partialOrder->id)->where('product_id', $itemToReturn->product_id)->update(['delivery_status' => 'Returned']);

        //PARTIALLY RETURNED ORDER #2
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

        $partialOrder->update(['order_status' => $status]);
        DB::table('order_details')->where('order_id', $partialOrder->id)->where('product_id', $itemToReturn->product_id)->update(['delivery_status' => 'Returned']);


         $this->command->info('Attempted to create two partially returned orders.');

    }
}
