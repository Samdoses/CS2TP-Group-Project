<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{

    //show checkout page
    public function index()
    {
        $user = Auth::user();

        // load items and products
        $basket = $user->basket()->with('items.product')->first();

        // Check if basket exists and has items
        if (!$basket || $basket->items->isEmpty()) {
            return redirect()->route('store.index');
        }

        // Put the database data into an array for a more suitabe view
        $cartItems = $basket->items->map(function($item) {
            return [
                'name' => $item->product->product_name,
                'price' => $item->product->product_price,
                'quantity' => $item->quantity,
            ];
        });

        // Calculate subtotal
        $subtotal = $cartItems->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('checkout', compact('cartItems', 'subtotal'));
    }

    //handles orders
    public function processOrder(Request $request)
    {

        // Valid data
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'postcode' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'delivery_method' => 'required|in:standard,express',
        ]);

        // Get users basket from database
        $user = Auth::user();
        $basket = $user->basket()->with('items.product')->first();

        if (!$basket || $basket->items->isEmpty()) {
            return redirect()->route('store.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

            //checks stock is validated
        foreach ($basket->items as $item) {
            if ($item->product->product_stock == 0){
                return redirect()->route('basket.view')->with('error','The '.$item->product->product_name. 'is out of stock.');
            }
            if ($item->product->product_stock < $item->quantity) {
                return redirect()->route('basket.view')->with('error','There are only '.$item->product->product_stock.' available '. $item->product->product_name . 's');
            }
        }

        // calculate total cost from the servers side
        $subtotal = 0;
        foreach ($basket->items as $item) {
            $subtotal += $item->product->product_price * $item->quantity;
        }

        //calculate shipping cost based on method picked
        $shippingCost = $validatedData['delivery_method'] === 'express' ? 6.95 : 3.95;
        $grandTotal = $subtotal + $shippingCost;

        // Create order in database
        $order = new Order();
        $order->user_id = $user->id;
        $order->order_date = now();
        $order->order_status = 'Placed';
        $order->delivery_method = $validatedData['delivery_method'];

        $fullAddress = $validatedData['address_line_1'] . ', ';
        if (!empty($validatedData['address_line_2'])) {
            $fullAddress .= $validatedData['address_line_2'] . ', ';
        }
        $fullAddress .= $validatedData['city'] . ', ' . $validatedData['postcode'];

        $order->order_address = $fullAddress;


        $order->total_price = $grandTotal;

        $order->save();

        // Moves items from basket to orders
        foreach ($basket->items as $item) {
            DB::table('order_details')->insert([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'order_price' => $item->product->product_price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // empty basket after order has been succesful
        $basket->items()->delete();

        return redirect()->route('checkout.success')->with([
            'success' => 'Thank you for your order!',
            'order_total' => $grandTotal
        ]);
    }


    public function success()
    {
        if (!session()->has('success')) {
            return redirect('/');
        }
        return view('checkout-success');
    }
}
