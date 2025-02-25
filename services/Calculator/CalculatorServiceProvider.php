<?php
namespace Services\Calculator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class CalculatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // load migrations
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/views', 'calculator');

        // Register service in app
        $this->app->singleton('calculator', function () {
            return new CalculatorService();
        });
    }
}
