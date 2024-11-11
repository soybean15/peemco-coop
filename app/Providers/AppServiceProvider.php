<?php

namespace App\Providers;

use App\Models\User;
use App\Services\Permissions\PermissionGates;
use App\Services\Settings\GeneralSettingsService;
use App\Services\Users\UserManagementService;
use App\View\Components\Charts\AreaChart;
use App\View\Components\Charts\BarChart;
use App\View\Components\Charts\ColumnChart;
use App\View\Components\Charts\PieChart;
use App\View\Components\Layout\SideBar;
use App\View\Components\SystemLogo;
use App\View\Components\UserProfileView;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserManagementService::class, function (Application $app) {

            $superAdmin= env('SUPER_ADMIN','test@example.com');

            $user = User::where('email',$superAdmin)->first();
            return new UserManagementService($user);
        });


        $this->app->singleton(GeneralSettingsService::class, function (Application $app) {

            return new GeneralSettingsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        //check if permissions table exist
        if (Schema::hasTable('permissions')) {
            PermissionGates::generate();
        }

        Blade::component('side-bar',SideBar::class);
        Blade::component('profile-view',UserProfileView::class);



        //charts
        Blade::component('bar-chart',BarChart::class);
        Blade::component('area-chart',AreaChart::class);
        Blade::component('pie-chart',PieChart::class);

        Blade::component('column-chart',ColumnChart::class);
        Blade::component('brand',SystemLogo::class);


    }


}
