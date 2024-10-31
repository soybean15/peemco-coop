<?php

namespace App\Providers;

use App\Models\User;
use App\Services\Permissions\PermissionGates;
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


        PermissionGates::generate();
        Blade::component('side-bar',SideBar::class);
        Blade::component('profile-view',UserProfileView::class);
    }


}
