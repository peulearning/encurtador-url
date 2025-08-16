<?php

namespace App\Providers;

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
        $this->app->router->group([
            'middleware' => 'api',
            'prefix' => 'api',
        ], function () {
            require base_path('routes/api.php');
        });

        $this->app->router->group([
            'middleware' => 'web',
        ], function () {
            require base_path('routes/web.php');
        });
    }
}
