<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Basket;    
use App\Models\BasketItem; 
use Illuminate\Support\Facades\Auth; 

class StoreController extends Controller
{

    public function viewBasket()
    {
        // Get authenticated user's basket 
        $basket = Auth::user()
            ->basket() 
            ->with(['items.product']) 
            ->first();

        // Pass data into the basket view
        return view('basket', compact('basket'));
    }

    public function removeItem(Request $request)
    {
        $request->validate([
            'basket_item_id' => 'required|integer|exists:basket_items,id',
        ]);

        BasketItem::destroy($request->input('basket_item_id'));

        return redirect()->route('basket.view')->with('success', 'Item removed from basket.');
    }

    // updates quantity of a basket item
    public function updateQuantity(Request $request)
        {
            $request->validate([
                'basket_item_id' => 'required|integer|exists:basket_items,id',
                'action' => 'required|in:increment,decrement',
            ]);

            $basketItem = BasketItem::findOrFail($request->input('basket_item_id'));

            if ($request->input('action') === 'increment') {
                $basketItem->increment('quantity');
            } else {
                // Decrement Logic
                if ($basketItem->quantity > 1) {
                    $basketItem->decrement('quantity');
                } else {
                    $basketItem->delete();
                }
            }

            return redirect()->route('basket.view');
        }

    // Fetches all products and displays the store page
    public function index()
    {
        $products = Product::all();
        return view('store', compact('products'));
    }

    // Handles adding products to the user's basket
    public function addToBasket(Request $request)
    {
        // 1. Authentication Check
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to add items to your basket.');
        }

        // Validations
        $request->validate([
            'product_id' => 'required|integer|exists:products,id', 
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $userId = Auth::id();

        // Find or create a basket for the user so every user has only one basket in darabase
        $basket = Basket::firstOrCreate(
            ['user_id' => $userId],
            []
        );

        // Find the basket,if not then create a new one
        $basketItem = BasketItem::where('basket_id', $basket->id)
                                ->where('product_id', $productId)
                                ->first();

        if ($basketItem) {
            // if the item arleady exists then increment it by the quantity
            $basketItem->quantity += $quantity;
            $basketItem->save();
            $message = 'Quantity updated in your basket!';
        } else {
            // if item doesnt exist, then create a new item
            BasketItem::create([
                'basket_id' => $basket->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
            $message = 'Product added to your basket!';
        }

        // Redirect with success message
        return redirect()->route('store.index')->with('success', $message);
    }
    
    public function show() {
        // ill impleement this later to show a single product view
    }
}