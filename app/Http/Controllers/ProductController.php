<?php

namespace App\Http\Controllers;
use App\Models\Product;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product-page', compact('products'));
    }

    public function show(Product $product)
    {
        return view('product-page', compact('product'));
    }

}
