<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Http\Request;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GoogleAuthController;
use App\Livewire\PartPicker;

// Public Routes

/*Route::get('/', function () {
    return view('index');
})->name('home');*/ //removed this duplicate route, its already linked to index in store controller bestseller

Route::get('/', [StoreController::class, 'bestSeller'])->name('home');

Route::get('/store', [StoreController::class, 'index'])->name('store.index');

Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
//view the review image expanded on another tab
// Route to show a single review image in full screen
Route::get('/review/image/{review}', function (App\Models\Review $review) {
    return view('show-image', ['review' => $review]);
})->name('reviews.image.show');

Route::get('/search', function () {
    return view('store');
})->name('search');

Route::get('/help', function () {
    return view('contact');
})->name('help');

Route::get('/cc', function () {
    return view('cc');
})->name('cc');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/build-guide', function () {
    return view('build-guide');
})->name('build-guide');

Route::get('/part-picker', function () {
    return view('partpicker-link'); // This points to your partpicker-link.blade.php file
})->name('part-picker');


Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::post('/contact', function (Request $request) {
    $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);
    return back()->with('status', 'Message sent successfully!');
});

Route::get('/temp-pp', [ProductController::class, 'index'])->name('product.temp');

//Google Auth
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'processOrder'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// Authenticated Routes (Requires Login)

Route::middleware(['auth'])->group(function () {

    Route::redirect('settings', 'settings/profile');

    // Profile Dashboard & Tabs
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    //View past order
    // past order details route
    Route::get('orders/{order}', [ProfileController::class,'viewOrder'])->name('profile.orders.show');

    //Review Routes
    Route::get('/reviews/create/{order}/{product}', [ReviewController::class, 'createReview'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');

    // Basket Functionality
    Route::get('/my-basket', [StoreController::class, 'viewBasket'])->name('basket.view');
    Route::post('/basket/add', [StoreController::class, 'addToBasket'])->name('basket.add');
    Route::post('/basket/remove', [StoreController::class, 'removeItem'])->name('basket.remove');
    Route::post('/basket/update', [StoreController::class, 'updateQuantity'])->name('basket.update');

    // Profile Tabs & Actions
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/security', [ProfileController::class, 'security'])->name('profile.security');
    Route::get('/profile/reviews', [ProfileController::class, 'reviews'])->name('profile.reviews');

    // Profile Actions (PUT/Update)
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Email Verification Flow
    Route::get('/profile/verify-email-change', [ProfileController::class, 'verifyEmailPage'])->name('profile.verify-email');
    Route::post('/profile/verify-email-change', [ProfileController::class, 'verifyEmailAction'])->name('profile.verify-email.store');

    // Basket Functionality (Protected Access)
    Route::get('/basket', [StoreController::class, 'viewBasket'])->name('basket.view');
    Route::post('/basket/add', [StoreController::class, 'addToBasket'])->name('basket.add');
    Route::post('/basket/remove', [StoreController::class, 'removeItem'])->name('basket.remove');
    Route::post('/basket/update', [StoreController::class, 'updateQuantity'])->name('basket.update');

    // Settings (Volt Components)
    Volt::route('settings/profile', 'initial views.livewire.settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'initial views.livewire.settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'initial views.livewire.settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'initial views.livewire.settings.two-factor')
        ->middleware(['password.confirm'])
        ->name('two-factor.show');
});
