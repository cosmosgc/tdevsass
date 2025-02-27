<?php
namespace App\Services;

use App\Models\Service;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Application;

class ServiceLoader extends ServiceProvider
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
                Route::middleware(['web'])->group(function () use ($routeFile) {
                    require $routeFile; // ✅ Correct way to include the file
                });
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
    public static function registerServiceProviders()
    {
        $servicePath = base_path('services');
        $directories = File::directories($servicePath);

        foreach ($directories as $dir) {
            $serviceName = basename($dir);
            $providerClass = "Services\\{$serviceName}\\{$serviceName}ServiceProvider";

            if (class_exists($providerClass)) {
                app()->register($providerClass); // Agora usamos `app()` em vez de `$this->app`
            }
        }
    }


    public static function loadServiceViews()
    {
        $servicePath = base_path('services');
        $directories = File::directories($servicePath);

        foreach ($directories as $dir) {
            $serviceName = basename($dir);
            $viewPath = "{$dir}/resources/views";

            if (File::exists($viewPath) && is_dir($viewPath)) {
                app()->make('view')->addNamespace($serviceName, $viewPath);

                // Log the namespace and path
                Log::info("View namespace registered: {$serviceName} -> {$viewPath}");

                // Print to console when running in Artisan commands
                //dump("View namespace registered: {$serviceName} -> {$viewPath}");
            }
        }
    }

    public static function loadServiceCommands()
    {
        $servicePath = base_path('services');
        $directories = File::directories($servicePath);

        foreach ($directories as $dir) {
            $serviceName = basename($dir);
            $commandPath = "{$dir}/Console/Commands";

            if (File::exists($commandPath) && is_dir($commandPath)) {
                foreach (File::files($commandPath) as $commandFile) {
                    $commandClass = "Services\\{$serviceName}\\Console\\Commands\\" . pathinfo($commandFile, PATHINFO_FILENAME);

                    if (class_exists($commandClass)) {
                        Application::starting(function ($artisan) use ($commandClass) {
                            $artisan->resolveCommands($commandClass);
                        });


                        Log::info("Comando Artisan registrado: {$commandClass}");
                    }
                }
            }
        }
    }
    public static function loadServiceJobs()
    {
        $servicePath = base_path('services');
        $directories = File::directories($servicePath);

        foreach ($directories as $dir) {
            $serviceName = basename($dir);
            $jobPath = "{$dir}/Jobs";

            if (File::exists($jobPath) && is_dir($jobPath)) {
                foreach (File::files($jobPath) as $jobFile) {
                    $jobClass = "Services\\{$serviceName}\\Jobs\\" . pathinfo($jobFile, PATHINFO_FILENAME);

                    if (class_exists($jobClass)) {
                        app()->bind($jobClass, function ($app) use ($jobClass) {
                            return new $jobClass();
                        });

                        Log::info("Job registrado: {$jobClass}");
                    }
                }
            }
        }
    }






}

