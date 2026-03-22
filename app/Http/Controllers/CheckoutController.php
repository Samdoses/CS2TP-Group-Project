<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
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

        // Valid data with strict enhancements
        $validatedData = $request->validate([
            'full_name' => 'required|string|min:2|max:255|regex:/^[a-zA-Z\s\-\']+$/',
            'address_line_1' => 'required|string|min:5|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|min:2|max:100|regex:/^[a-zA-Z\s\-]+$/',
            'postcode' => 'required|string|min:4|max:10|regex:/^[a-zA-Z0-9\s\-]+$/', // Validates general UK/Global alphanumeric postcodes
            'email' => 'required|email:rfc,dns|max:255', // Checks domain validity
            'delivery_method' => 'required|in:standard,express',

            'card_number' => 'nullable|min:16',
            'expiry' => 'nullable|regex:/^(0[1-9]|1[0-2])\/\d{2}$/',
            'cvv' => 'nullable|min:3|max:4',
            'card_name' => 'nullable|string|max:255',
        ], [
            // Custom messages for the user
            'full_name.regex' => 'Your full name must only contain letters, spaces, and hyphens.',
            'city.regex' => 'The city name is invalid.',
            'postcode.regex' => 'Please enter a valid alphanumeric postcode.',
        ]);

        // Get users basket from database
        $user = Auth::user();
        $basket = $user->basket()->with('items.product')->first();

        if (!$basket || $basket->items->isEmpty()) {
            return redirect()->route('store.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

            //checks stock is validated
        return DB::transaction(function () use ($basket, $validatedData, $user) {

        $subtotal = 0;

        foreach ($basket->items as $item) {

            if ($item->product->product_stock == 0){
                throw new \Exception("The item {$item->product->product_name} is no longer in stock.");
            }
            if ($item->product->product_stock < $item->quantity) {
                return redirect()->route('basket.view')->with('error','There are only '.$item->product->product_stock.' available '. $item->product->product_name . 's');
            }

            $item->product->decrement('product_stock', $item->quantity);
            // calculate total cost from the servers side
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
        $order->created_at = now();
        $order->updated_at = now();

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
                'delivery_status' => 'Pending',
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
        }, 5);
    }


    public function success()
    {
        if (!session()->has('success')) {
            return redirect('/');
        }
        return view('checkout-success');
    }

    public function directCheckout(Request $request)
    {
        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Find the product
        $product = \App\Models\Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        // Format as a collection so your checkout.blade.php iterates over it correctly
        $cartItems = collect([[
            'name' => $product->product_name,
            'price' => $product->product_price,
            'quantity' => $quantity,
        ]]);

        // Name this $subtotal to match your blade file!
        $subtotal = $product->product_price * $quantity;

        return view('checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'isDirectCheckout' => true,      // Flag to tell the view what form to use
            'directProductId' => $product->id, // Passing ID so the form can submit it
            'directQuantity' => $quantity
        ]);
    }

    // Handles the final payment/submission for the direct item ONLY
    public function processDirectOrder(Request $request)
    {

        // Valid data with strict enhancements
        $validatedData = $request->validate([
            'full_name' => 'required|string|min:2|max:255|regex:/^[a-zA-Z\s\-\']+$/',
            'address_line_1' => 'required|string|min:5|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|min:2|max:100|regex:/^[a-zA-Z\s\-]+$/',
            'postcode' => 'required|string|min:4|max:10|regex:/^[a-zA-Z0-9\s\-]+$/', // Validates general UK/Global alphanumeric postcodes
            'email' => 'required|email:rfc,dns|max:255', // Checks domain validity
            'delivery_method' => 'required|in:standard,express',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',

            'card_number' => 'nullable|min:16',
            'expiry' => 'nullable|min:4|max:4',
            'cvv' => 'nullable|min:3|max:4',
            'card_name' => 'nullable|string|max:255',
        ], [
            // Custom messages for the user
            'full_name.regex' => 'Your full name must only contain letters, spaces, and hyphens.',
            'city.regex' => 'The city name is invalid.',
            'postcode.regex' => 'Please enter a valid alphanumeric postcode.',
        ]);

        $user = Auth::user();
        $product = \App\Models\Product::findOrFail($validatedData['product_id']);
        $quantity = $validatedData['quantity'];

        return DB::transaction(function () use ($validatedData, $user, $product, $quantity) {

            // Stock checks
            if ($product->product_stock == 0){
                throw new \Exception("The item {$product->product_name} is no longer in stock.");
            }
            if ($product->product_stock < $quantity) {
                return redirect()->back()->with('error','There are only '.$product->product_stock.' available '. $product->product_name . 's');
            }

            // Decrement stock
            $product->decrement('product_stock', $quantity);

            $subtotal = $product->product_price * $quantity;
            $shippingCost = $validatedData['delivery_method'] === 'express' ? 6.95 : 3.95;
            $grandTotal = $subtotal + $shippingCost;

            // Create order in database
            $order = new Order();
            $order->user_id = $user->id;
            $order->order_date = now();
            $order->order_status = 'Placed';
            $order->delivery_method = $validatedData['delivery_method'];
            $order->created_at = now();
            $order->updated_at = now();

            $fullAddress = $validatedData['address_line_1'] . ', ';
            if (!empty($validatedData['address_line_2'])) {
                $fullAddress .= $validatedData['address_line_2'] . ', ';
            }
            $fullAddress .= $validatedData['city'] . ', ' . $validatedData['postcode'];
            $order->order_address = $fullAddress;
            $order->total_price = $grandTotal;
            $order->save();

            // Moves the single item straight to order_details
            DB::table('order_details')->insert([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'delivery_status' => 'Pending',
                'order_price' => $product->product_price,
                'created_at' => now(),
                                               'updated_at' => now(),
            ]);

            // The user's original basket remains completely untouched.

            return redirect()->route('checkout.success')->with([
                'success' => 'Thank you for your order!',
                'order_total' => $grandTotal
            ]);
        }, 5);
    }
}
