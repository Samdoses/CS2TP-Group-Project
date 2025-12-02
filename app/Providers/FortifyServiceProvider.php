<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser; 
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Contracts\ResetsUserPasswords; 
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;

class FortifyServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ResetsUserPasswords::class,
            ResetUserPassword::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        
        Fortify::registerView(fn () => view('initial views.livewire.auth.register'));
        Fortify::loginView(fn () => view('initial views.livewire.auth.login'));
        Fortify::confirmPasswordView(fn () => view('initial views.livewire.auth.confirm-password'));
        Fortify::twoFactorChallengeView(fn () => view('initial views.livewire.auth.two-factor-challenge'));
        Fortify::requestPasswordResetLinkView(fn () => view('initial views.livewire.auth.forgot-password'));
        Fortify::resetPasswordView(fn () => view('initial views.livewire.auth.reset-password'));
        Fortify::verifyEmailView(fn () => view('initial views.livewire.auth.verify-email'));

        $this->configureRateLimiting();
    }

    /**
     * Configure rate limiting.
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('login', fn (Request $request) =>
            Limit::perMinute(5)->by(optional($request->user())->id ?: $request->ip())
        );

        if (Features::enabled(Features::twoFactorAuthentication())) {
            RateLimiter::for('two-factor', fn (Request $request) =>
                Limit::perMinute(5)->by($request->session()->get('login.id'))
            );
        }
    }
}