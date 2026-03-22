<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Category;
use App\Models\Review;
use App\Models\WebsiteReview;
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
        // Validations
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            // Added max:99 to prevent users from requesting absurdly large bulk numbers in a single request
            'quantity' => 'required|integer|min:1|max:99',
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
                //checks if quantity wanted does not exceed the stock limit
                if ($basketItem->product->product_stock > $basketItem->quantity){
                    $basketItem->increment('quantity');
                }
                else {
                    //if the quantity now exceeds stock limit
                    return redirect()->route('basket.view')->with('error', 'There are only '.$basketItem->product->product_stock.' available '. $basketItem->product->product_name . 's');

                }

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
        //gets products alongside their average ratings
        $products = Product::withAvg(['reviews' => function ($query) { $query->where('review_status', 'Approved'); }], 'rating')->paginate(12);
        $categories = Category::all();
        $colours = Product::select('product_colour')->distinct()->pluck('product_colour');
        $pcParts = Product::select('product_part')->distinct()->pluck('product_part');

        return view('store-page', compact('products', 'categories', 'colours', 'pcParts'));

    }

    public function bestSeller() {

        $bestSellers = Product::whereIn('id', [13, 3, 22])->withAvg(['reviews' => function ($query) { $query->where('review_status', 'Approved'); }], 'rating')->get();
        $websiteReviews = WebsiteReview::where('review_status', 'Approved')->latest()->paginate(3);

        $userReview = null;
        if (Auth::check()) {
            //finds the users review (pending or approved)
            $userReview = WebsiteReview::where('user_id', Auth::id())->first();
        }
        return view('index', compact('bestSellers', 'websiteReviews', 'userReview'));

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
        $stock = $request->input('product_stock');
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
            //if adding the item will not exceed stock limit
            if ($basketItem->product->product_stock > $basketItem->quantity){
                // if the item arleady exists then increment it by the quantity
                $basketItem->quantity += $quantity;
                $basketItem->save();
                $message = 'Quantity updated in your basket!';
                $errormessage = null;
            }
            else {
                $errormessage = 'We currently have limited stock of this product.';
            }

        } else {
            // if item doesnt exist, then create a new item
            $tempItem = BasketItem::create([
                'basket_id' => $basket->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);

            if ($tempItem->product->product_stock < $tempItem ->quantity ){
                $errormessage = 'We currently have limited stock of this product.';
                $tempItem->delete();
            }
            else {
                $message = 'Product added to your basket!';
                $errormessage = null;
            }

        }

        //if error message is empty display error, otherwise show success
        if ($errormessage != null) {
            return redirect()->back()->with('error', $errormessage);
        }
        else {
            // Redirect with success message, back to the page that it came from
            return redirect()->back()->with('success', $message);
        }

    }

    //used to fetch a specific product and display it on a single product page
    public function show($id) {
        $product = Product::findOrFail($id);
        return view('product-page', compact('product'));
    }
}
