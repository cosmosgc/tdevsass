<?php
namespace App\Services;

use App\Models\Service;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

class ServiceLoader
{
    public static function loadServices()
    {
        $servicePath = base_path('services');
        $directories = File::directories($servicePath);

        foreach ($directories as $dir) {
            $jsonPath = $dir . '/service.json';

            if (File::exists($jsonPath)) {
                $serviceData = json_decode(File::get($jsonPath), true);

                // Store service in DB if not exists
                Service::updateOrCreate(
                    ['slug' => $serviceData['slug']],
                    [
                        'name' => $serviceData['name'],
                        'description' => $serviceData['description'],
                        'price' => $serviceData['price'],
                        'active' => $serviceData['active'] ?? true
                    ]
                );
            }
        }
    }

    public static function loadServiceRoutes()
    {
        $servicePath = base_path('services');
        $directories = File::directories($servicePath);

        foreach ($directories as $dir) {
            $routeFile = $dir . '/routes.php';

            if (File::exists($routeFile)) {
                Route::middleware(['web'])->group($routeFile);
            }
        }
    }

    public static function loadServiceMigrations()
    {
        $servicePath = base_path('services');
        $directories = File::directories($servicePath);

        foreach ($directories as $dir) {
            $migrationPath = $dir . '/database/migrations';
            if (File::exists($migrationPath)) {
                Artisan::call('migrate', ['--path' => str_replace(base_path() . '/', '', $migrationPath)]);
            }
        }
    }


}

