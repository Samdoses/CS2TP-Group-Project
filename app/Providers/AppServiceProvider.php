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
            $basketPreview = null;
            $basketSubtotal = 0;

            if (Auth::check()) {
                $basketPreview = Basket::query()
                    ->where('user_id', Auth::id())
                    ->with(['items.product'])
                    ->first();

                if ($basketPreview) {
                    $basketCount = $basketPreview->items->sum('quantity');
                    $basketSubtotal = $basketPreview->items->sum(function ($item) {
                        return (int) $item->quantity * (int) ($item->product->product_price ?? 0);
                    });
                }
            }

            $view->with([
                'globalBasketCount' => $basketCount,
                'globalBasketPreview' => $basketPreview,
                'globalBasketSubtotal' => $basketSubtotal,
            ]);
        });


    }
}
