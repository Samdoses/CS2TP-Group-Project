<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Basket;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        Blade::anonymousComponentPath(
            base_path('resources/views/components'),
            'components'
        );

        Blade::anonymousComponentPath(
            base_path('resources/views/components/layouts'),
            'layouts'
        );

        //the most efficient way to keep the basket icon up to date with the header
        View::composer('*', function ($view) {
            $basketCount = 0;

            if (Auth::check()) {
                // Get the user's basket and sum the quantities of all items
                $basketCount = Basket::where('user_id', Auth::id())
                    ->with('items')
                    ->get()
                    ->pluck('items')
                    ->flatten()
                    ->sum('quantity');
            } else {
                // Optional: If you use sessions for guest baskets, count those here
                // $basketCount = count(session('guest_basket', []));
            }

            $view->with('globalBasketCount', $basketCount);
        });


    }
}
