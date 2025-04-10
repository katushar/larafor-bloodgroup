<?php

namespace Larafor\Bloodgroup;

use Illuminate\Support\ServiceProvider;
use Larafor\Bloodgroup\Console\Commands\CreateBloodGroupMigration;

class BloodGroupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bloodgroup.php', 'bloodgroup');

        $this->commands([
            CreateBloodGroupMigration::class,
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->publishes([
            __DIR__.'/../config/bloodgroup.php' => config_path('bloodgroup.php'),
        ], 'bloodgroup-config');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');


        // Optionally, load views or assets if needed
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'bloodgroup');
        // $this->publishes([
        //     __DIR__.'/../resources/views' => resource_path('views/vendor/bloodgroup'),
        // ], 'bloodgroup-views');
    }
}
