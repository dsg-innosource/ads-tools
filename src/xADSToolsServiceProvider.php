<?php

namespace InnoSource\ADSTools;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use InnoSource\ADSTools\Console\Commands\CreateFunction;
use InnoSource\ADSTools\Console\Commands\CreateSqlTest;
use InnoSource\ADSTools\Console\Commands\CreateStoredProcedure;
use InnoSource\ADSTools\Console\Commands\CreateView;
use InnoSource\ADSTools\Console\Commands\MigrateFunctions;
use InnoSource\ADSTools\Console\Commands\MigrateStoredProcedures;
use InnoSource\ADSTools\Console\Commands\MigrateViews;
use InnoSource\ADSTools\Console\Commands\Rebuild;
use InnoSource\ADSTools\Console\Commands\SqlTest;

class ADSToolsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerResources();
    }

    public function register()
    {
        $this->configure();
        $this->offerPublishing();
        $this->registerCommands();
        $this->registerHelpers();
        $this->registerRoutes();
        $this->defineAssetPublishing();
    }

    protected function registerRoutes()
    {
        Route::group([
            'prefix' => config('ads-tools.uri', 'ads-tools'),
            'namespace' => 'InnoSource\ADSTools\Http\Controllers',
            'middleware' => config('ads-tool.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    public function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/ads-tools.php',
            'ads-tools'
        );
    }

    public function defineAssetPublishing()
    {
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/ads-tools'),
        ], 'ads-tools-assets');
    }

    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ads-tools');
    }

    public function registerCommands()
    {
        $this->commands(SqlTest::class);
        $this->commands(Rebuild::class);
        $this->commands(CreateView::class);
        $this->commands(MigrateViews::class);
        $this->commands(CreateSqlTest::class);
        $this->commands(CreateFunction::class);
        $this->commands(MigrateFunctions::class);
        $this->commands(CreateStoredProcedure::class);
        $this->commands(MigrateStoredProcedures::class);
    }

    public function registerHelpers()
    {
        require __DIR__ . '/../helpers.php';
    }

    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/ads-tools.php' => config_path('ads-tools.php'),
            ]);
        }
    }
}
