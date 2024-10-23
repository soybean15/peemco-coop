<?php

namespace App\Providers;

use App\Services\LoanCalculator\LoanCalculator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class LoanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(LoanCalculator::class, function (Application $app) {
            return new LoanCalculator(Auth::user());
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
