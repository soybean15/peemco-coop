<?php

namespace App\Providers;

use App\Models\User;
use App\Services\Permissions\PermissionGates;
use App\View\Components\Charts\AreaChart;
use App\View\Components\Charts\BarChart;
use App\View\Components\Charts\ColumnChart;
use App\View\Components\Charts\PieChart;
use App\View\Components\Layout\SideBar;
use App\View\Components\UserProfileView;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
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


    }


}
