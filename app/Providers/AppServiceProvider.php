<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        Blade::anonymousComponentPath(
            base_path('resources/views/initial views/components'), 
            'components'
        );

        Blade::anonymousComponentPath(
            base_path('resources/views/initial views/components/layouts'),
            'layouts'
        );
        

    }
}