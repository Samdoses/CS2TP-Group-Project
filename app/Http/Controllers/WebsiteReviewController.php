<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WebsiteReview;

class WebsiteReviewController extends Controller
{

    public function index()
    {
        //fetch reviews with pagination
        $allReviews = WebsiteReview::latest()->paginate(3);

        //checks user has already submitted one review
        $userReview = Auth::check() ? WebsiteReview::where('user_id', Auth::id())->first() : null;

        return view('website-reviews.index', compact('allReviews', 'userReview'));
    }

    public function edit(WebsiteReview $websiteReview)
    {
        abort(403, 'Website reviews cannot be edited after submission.');
    }

  public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|max:500',
        ]);

        $websiteReview = new WebsiteReview();
        $websiteReview->user_id = Auth::id();
        $websiteReview->rating = $request->rating;
        $websiteReview->review_text = $request->review_text;
        $websiteReview->review_status = 'Pending';
        $websiteReview->created_at = now();
        $websiteReview->updated_at = now();

        $websiteReview->save();

        return back()->with('success', 'Thanks! Your website review is pending approval.');
    }

    public function update(Request $request, WebsiteReview $websiteReview)
    {
        abort(403, 'Website reviews cannot be edited after submission.');
    }

    public function destroy(WebsiteReview $websiteReview)
    {
        if ($websiteReview->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $websiteReview->delete();
        return back()->with('success', 'Review deleted.');
    }

}
