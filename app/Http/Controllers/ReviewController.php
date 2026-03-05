<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;

class ReviewController extends Controller
{

    public function createReview(Order $order, Product $product)
    {

        //check that this is their order and that the order is delivered
        if ($order->user_id !== Auth::id()) {
            abort(403, 'This is not your order.'); //send forbidden message 403
        }

        if ($order->order_status !== 'Delivered') {
            return redirect()->back()->with('error', 'You can only review delivered items.');
        }

        //checks if they have already reviewed this product for this specific order

        $exists = Review::where('order_id', $order->id)->where('product_id', $product->id)->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'You have already reviewed the ' . $product->product_name . ' in this order.');
        }

        return view('create-review-page', compact('order', 'product'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:500',
            'review_image' => 'nullable|image|max:2048',
        ]);

        //LATER AFTER JOT DOES THE ADMIN PAGE I WILL SEND REVIEWS THERE TO BE REVIEWED BEFORE POSTED
        //because of evil cs2tp competitors
        //saves the new review to the database where it is retrieved on the product page later
        //i introuduce a new status for reviews here

        //double check authorisation again
        $order = Order::findOrFail($request->order_id);
        if ($order->user_id !== Auth::id() || $order->order_status !== 'Delivered') {
            return redirect()->back()->withErrors(['security' => 'Unauthorised review attempt.']);
        }

        if (strlen($request->review_text) > 500) {
            return redirect()->back()->withInput()->withErrors(['review_text' => 'Your review is too long! Please limit it to 500 characters.']);
        }

        $review = new Review();
        $review->user_id = Auth::id();
        $review->review_status = 'Pending';
        $review->order_id = $request->order_id;
        $review->product_id = $request->product_id;
        $review->rating = $request->rating;
        $review->review_text = $request->review_text;
        $review->created_at = now();

        //image upload onto the github and phpmyadmin database
        if ($request->hasFile('review_image')) {
            $file = $request->file('review_image');

            //generate unique filename using uniqueids and timestamps
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            //move the file ot the correct location and save it to the database
            $file->move(public_path('images/reviews'), $fileName);
            $review->review_image = $fileName;
        }

        $review->save();

        return redirect()->route('profile.orders.show', $request->order_id)->with('success', 'Thank you for your review!');
    }

    public function destroy(Review $review)
    {
        //makes sure the user is logged in and the review belongs to them before they delete it
        if ($review->user_id !== Auth::id()) {
            abort(403, 'This is not your review.');
        }

        //deletes the review image from the database (as well as the github) as the review is deleted
        //later i will properly implement this as i still need the images for the seeder
        /*
        if ($review->review_image) {
            $imagePath = public_path('images/reviews/' . $review->review_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }*/
        //i can delete it from the database because that doesnt affect the github files
        $review->delete();

        return redirect()->route('profile.reviews')->with('status', 'Review deleted successfully.');
    }

public function edit(Review $review)
{
    if ($review->user_id !== Auth::id()) {
        abort(403, 'This is not your review.');
    }

    //we need the product and order info for the header of the edit page
    $review->load(['product', 'order.orderDetails']);
    $product = $review->product;
    $order = $review->order;

    return view('edit-review-page', compact('review', 'product', 'order'));
}

public function update(Request $request, Review $review)
{
    if ($review->user_id !== Auth::id()) {
        abort(403, 'This is not your review.');
    }

    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review_text' => 'nullable|string|max:500',
        'review_image' => 'nullable|image|max:2048',
    ]);

    $review->rating = $request->rating;
    $review->review_text = $request->review_text;
    $review->review_status = 'Pending';

    if ($request->hasFile('review_image')) {
        //deletes old image if it exists
        //later i will properly implement this as i still need the images for the seeder
        //otherwise it makes permanent changes on github as i use it to store the review images
        /*
        if ($review->review_image) {
            @unlink(public_path('images/reviews/' . $review->review_image));
        }*/

        $file = $request->file('review_image');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/reviews'), $fileName);
        $review->review_image = $fileName;
    }

    $review->save();

    return redirect()->route('profile.reviews')->with('status', 'Review updated and is now pending approval!');
}
}
