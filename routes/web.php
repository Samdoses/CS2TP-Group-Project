<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\WebsiteReviewController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/dashboard');
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('orders.index');
        Route::get('/products', [AdminDashboardController::class, 'products'])->name('products.index');
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users.index');
        Route::get('/messages', [AdminDashboardController::class, 'messages'])->name('messages.index');
        Route::get('/reviews', [AdminDashboardController::class, 'websiteReviews'])->name('reviews.index');
        Route::get('/messages/{message}', [AdminDashboardController::class, 'showMessage'])->name('messages.show');
        Route::post('/messages/{message}/reply', [AdminDashboardController::class, 'replyToMessage'])->name('messages.reply');
        Route::patch('/reviews/{websiteReview}', [AdminDashboardController::class, 'updateWebsiteReviewStatus'])->name('reviews.update');
        Route::get('/returns', [AdminDashboardController::class, 'returns'])->name('returns.index');
        Route::patch('/orders/{order}', [AdminDashboardController::class, 'updateOrderStatus'])->name('orders.update');
        Route::post('/orders/{order}/items/{orderDetail}/support-resolution', [AdminDashboardController::class, 'resolveSupportItem'])->name('orders.items.resolve');
        Route::post('/products', [AdminDashboardController::class, 'storeProduct'])->name('products.store');
        Route::delete('/products/{product}', [AdminDashboardController::class, 'destroyProduct'])->name('products.destroy');
        Route::patch('/order-items/{orderDetail}/delivery-status', [AdminDashboardController::class, 'updateDeliveryStatus'])->name('order-items.delivery-status');
        Route::patch('/returns/{returnOrder}', [AdminDashboardController::class, 'updateReturnStatus'])->name('returns.update');
        Route::middleware('head.admin')->group(function () {
            Route::get('/management', [AdminManagementController::class, 'index'])->name('management.index');
            Route::post('/management/admins', [AdminManagementController::class, 'store'])->name('management.store');
        });
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

Route::get('/', [StoreController::class, 'bestSeller'])->name('home');
Route::get('/store', [StoreController::class, 'index'])->name('store.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('/review/image/{review}', function (App\Models\Review $review) {
    return view('show-image', ['review' => $review]);
})->name('reviews.image.show');

Route::get('/search', function () {
    return view('store');
})->name('search');

Route::get('/help', [ContactController::class, 'show'])->name('help');

Route::get('/cc', function () {
    return view('cc');
})->name('cc');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/build-guide', function () {
    return view('build-guide');
})->name('build-guide');

Route::get('/sitemap', function () {
    return view('sitemap');
})->name('sitemap');

Route::get('/part-picker', function () {
    return view('partpicker-link');
})->name('part-picker');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/temp-pp', [ProductController::class, 'index'])->name('product.temp');
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'processOrder'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/website-reviews', [WebsiteReviewController::class, 'index'])->name('website-reviews.index');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/security', [ProfileController::class, 'security'])->name('profile.security');
    Route::get('/profile/reviews', [ProfileController::class, 'reviews'])->name('profile.reviews');
    Route::get('/profile/messages', [ProfileController::class, 'messages'])->name('profile.messages');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/profile/verify-email-change', [ProfileController::class, 'verifyEmailPage'])->name('profile.verify-email');
    Route::post('/profile/verify-email-change', [ProfileController::class, 'verifyEmailAction'])->name('profile.verify-email.store');
    Route::get('orders/{order}', [ProfileController::class, 'viewOrder'])->name('profile.orders.show');
    Route::get('/order/{order}/return-item/{product}', [ReturnController::class, 'showReturnForm'])->name('orders.return.item');
    Route::post('/order/{order}/return-all', [ReturnController::class, 'returnEntireOrder'])->name('orders.return.all');
    Route::post('/order/{order}/return-item/{product}/process', [ReturnController::class, 'processReturn'])->name('orders.return.process');
    Route::delete('/returns/{return}/cancel-pending', [ReturnController::class, 'cancelPendingReturn'])->name('orders.return.cancel');
    Route::post('/website-reviews', [WebsiteReviewController::class, 'store'])->name('website-reviews.store');
    Route::delete('/website-reviews/{websiteReview}', [WebsiteReviewController::class, 'destroy'])->name('website-reviews.destroy');
    Route::post('/order/{order}/cancel', [ReturnController::class, 'cancel'])->name('orders.cancel');
    Route::get('/reviews/create/{order}/{product}', [ReviewController::class, 'createReview'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::get('/my-basket', [StoreController::class, 'viewBasket'])->name('basket.view');
    Route::post('/basket/add', [StoreController::class, 'addToBasket'])->name('basket.add');
    Route::post('/basket/remove', [StoreController::class, 'removeItem'])->name('basket.remove');
    Route::post('/basket/update', [StoreController::class, 'updateQuantity'])->name('basket.update');
    Route::get('/checkout/direct', [CheckoutController::class, 'directCheckout'])->name('checkout.direct');
    Route::post('/checkout/process-direct', [CheckoutController::class, 'processDirectOrder'])->name('checkout.processDirect');
    Route::get('/basket', [StoreController::class, 'viewBasket'])->name('basket.view');
    Route::post('/basket/add', [StoreController::class, 'addToBasket'])->name('basket.add');
    Route::post('/basket/remove', [StoreController::class, 'removeItem'])->name('basket.remove');
    Route::post('/basket/update', [StoreController::class, 'updateQuantity'])->name('basket.update');
    Volt::route('settings/profile', 'initial views.livewire.settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'initial views.livewire.settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'initial views.livewire.settings.appearance')->name('appearance.edit');
    Volt::route('settings/two-factor', 'initial views.livewire.settings.two-factor')
        ->middleware(['password.confirm'])
        ->name('two-factor.show');
});
