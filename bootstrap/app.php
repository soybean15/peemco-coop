<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__.'/../routes/web.php',
        // commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function () {
            Route::middleware(['web', 'role:super admin|book keeper'])

                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware(['web','auth'])
                ->prefix('user')
                ->group(base_path('routes/user.php'));

            Route::middleware(['api'])

                ->group(base_path('routes/api.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'is_admin' => \App\Http\Middleware\RedirectIfAdmin::class,



        ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
