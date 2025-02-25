<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

use App\Services\ServiceLoader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Dynamically load all service providers in the services/ directory
        foreach (File::directories(base_path('services')) as $serviceDir) {
            $serviceName = basename($serviceDir);
            $providerClass = "Services\\{$serviceName}\\{$serviceName}ServiceProvider"; // ✅ Match naming convention

            if (class_exists($providerClass)) {
                $this->app->register($providerClass);
            }
        }
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ServiceLoader::loadServices();
        ServiceLoader::loadServiceMigrations();
        ServiceLoader::registerServiceProviders();
        ServiceLoader::loadServiceRoutes();
        ServiceLoader::loadServiceViews();
    }

}
