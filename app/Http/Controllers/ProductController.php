<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function index()
    {
        //we will paginate so that only a certain amount of products are displayed per page
        $products = Product::all();
        return view('product-page', compact('products')); //old code is here just in case
    }

    public function show(Product $product)
    {
        $reviews = $product->reviews()->where('review_status', 'Approved')->latest()->paginate(3);

        return view('product-page', compact('product', 'reviews'));
    }

}
