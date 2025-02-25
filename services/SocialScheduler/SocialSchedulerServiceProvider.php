<?php
namespace Services\SocialScheduler;

use Illuminate\Support\ServiceProvider;

class SocialSchedulerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'social_scheduler');
    }
}

