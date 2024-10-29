<?php

namespace App\Providers;

use App\Models\User;
use App\View\Components\Layout\SideBar;
use App\View\Components\UserProfileView;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Gate::define('can add user', function (User $user) {
            return $user->hasPermission('manage all') || $user->hasPermission('can add user');
        });

        Blade::component('side-bar',SideBar::class);
        Blade::component('profile-view',UserProfileView::class);
    }


}
