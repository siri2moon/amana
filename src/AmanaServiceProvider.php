<?php

namespace Herode\Amana;

use Route;
use Illuminate\Support\ServiceProvider;

class AmanaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerResources();
        $this->registerMigrations();
        $this->defineAssetPublishing();
    }


    /**
     * Register the Horizon routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'domain'     => config('amana.domain', null),
            'prefix'     => config('amana.path'),
            'namespace'  => 'Herode\Amana\Http\Controllers',
            'middleware' => config('amana.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * Register the Horizon resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'amana');
    }

    /**
     * Register Migrations
     */
    protected function registerMigrations()
    {
        /** @noinspection PhpInconsistentReturnPointsInspection */
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        return $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function defineAssetPublishing()
    {
        $this->publishes([
            AMANA_PATH . '/public' => public_path('vendor/amana'),
        ], 'amana-assets');

        $this->publishes([
            AMANA_PATH . '/public/fonts' => public_path('fonts'),
        ], 'amana-fonts');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (!defined('AMANA_PATH')) {
            define('AMANA_PATH', realpath(__DIR__ . '/../'));
        }

        $this->offerPublishing();
        $this->registerCommands();
    }

    /**
     * Setup the resource publishing groups for Horizon.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/amana.php' => config_path('amana.php'),
            ], 'amana-config');

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'amana-migrations');
        }
    }

    /**
     * Register the Horizon Artisan commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\InstallCommand::class,
                Console\AssetsCommand::class,
            ]);
        }
    }
}
