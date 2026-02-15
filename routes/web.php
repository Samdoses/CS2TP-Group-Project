<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Http\Request;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;

// Public Routes

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/', [StoreController::class, 'bestSeller'])->name('home');

Route::get('/store', [StoreController::class, 'index'])->name('store.index');

Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

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

Route::post('/contact', function (Request $request) {
    $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);
    return back()->with('status', 'Message sent successfully!');
});

Route::get('/temp-pp', [ProductController::class, 'index'])->name('product.temp');

// past order details route
Route::get('orders/{order}', [ProfileController::class,'viewOrder'])->middleware('auth')->name('profile.orders.show');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'processOrder'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// Authenticated Routes (Requires Login)

Route::middleware(['auth'])->group(function () {

    Route::redirect('settings', 'settings/profile');

    // Profile Dashboard & Tabs
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

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
