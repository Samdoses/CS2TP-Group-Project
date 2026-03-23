<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use App\Models\WebsiteReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

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
            'basket_item_id' => 'required|integer|exists:basket_items,id',
        ]);

        $basketItem = BasketItem::query()
            ->whereKey($request->input('basket_item_id'))
            ->whereHas('basket', fn ($query) => $query->where('user_id', Auth::id()))
            ->firstOrFail();

        $basketItem->delete();

        if ($request->expectsJson()) {
            return $this->basketJsonResponse('Item removed from basket.');
        }

        return redirect()->back()->with('success', 'Item removed from basket.');
    }

    // updates quantity of a basket item
    public function updateQuantity(Request $request)
        {
            $request->validate([
                'basket_item_id' => 'required|integer|exists:basket_items,id',
                'action' => 'required|in:increment,decrement',
            ]);

            $basketItem = BasketItem::query()
                ->whereKey($request->input('basket_item_id'))
                ->whereHas('basket', fn ($query) => $query->where('user_id', Auth::id()))
                ->with('product')
                ->firstOrFail();

            if ($request->input('action') === 'increment') {
                //checks if quantity wanted does not exceed the stock limit
                if ($basketItem->product->product_stock > $basketItem->quantity){
                    $basketItem->increment('quantity');
                }
                else {
                    //if the quantity now exceeds stock limit
                    if ($request->expectsJson()) {
                        return $this->basketJsonResponse('There are only '.$basketItem->product->product_stock.' available '. $basketItem->product->product_name . 's', true, 422);
                    }

                    return redirect()->back()->with('error', 'There are only '.$basketItem->product->product_stock.' available '. $basketItem->product->product_name . 's');

                }

            } else {
                // Decrement Logic
                if ($basketItem->quantity > 1) {
                    $basketItem->decrement('quantity');
                } else {
                    $basketItem->delete();
                }
            }

            if ($request->expectsJson()) {
                return $this->basketJsonResponse();
            }

            return redirect()->back();
        }

    // Fetches all products and displays the store page
    public function index()
    {
        return view('store-page');
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

    private function basketJsonResponse(?string $message = null, bool $error = false, int $status = 200): JsonResponse
    {
        $basket = Basket::query()
            ->where('user_id', Auth::id())
            ->with(['items.product'])
            ->first();

        $basketCount = $basket?->items->sum('quantity') ?? 0;
        $basketSubtotal = $basket?->items->sum(function ($item) {
            return (int) $item->quantity * (int) ($item->product->product_price ?? 0);
        }) ?? 0;

        return response()->json([
            'message' => $message,
            'error' => $error,
            'basketCount' => $basketCount,
            'basketSubtotal' => $basketSubtotal,
            'basketPreviewHtml' => view('partials.basket-preview-panel', [
                'basketPreview' => $basket,
                'basketCount' => $basketCount,
                'basketSubtotal' => $basketSubtotal,
            ])->render(),
            'basketPageHtml' => view('partials.basket-page-content', [
                'basket' => $basket,
            ])->render(),
        ], $status);
    }
}
