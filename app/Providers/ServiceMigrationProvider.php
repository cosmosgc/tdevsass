<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class ServiceMigrationProvider extends ServiceProvider
{
    public function register()
    {
        // Load migrations dynamically
        $this->loadServiceMigrations();
    }

    protected function loadServiceMigrations()
    {
        $servicePath = base_path('services');
        $directories = File::directories($servicePath);
        $migrationPaths = [];

        foreach ($directories as $dir) {
            $migrationDir = $dir . '/database/migrations';

            if (File::exists($migrationDir)) {
                $migrationPaths[] = $migrationDir;
            }
        }

        // Register the service module migrations
        if (!empty($migrationPaths)) {
            $this->loadMigrationsFrom($migrationPaths);
        }
    }
}
