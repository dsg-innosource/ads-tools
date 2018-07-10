<?php

namespace ResultData\ADSTools;

use Illuminate\Support\ServiceProvider;
use ResultData\ADSTools\Console\Commands\Rebuild;
use ResultData\ADSTools\Console\Commands\SqlTest;
use ResultData\ADSTools\Console\Commands\CreateView;
use ResultData\ADSTools\Console\Commands\MigrateViews;
use ResultData\ADSTools\Console\Commands\CreateSqlTest;
use ResultData\ADSTools\Console\Commands\CreateFunction;
use ResultData\ADSTools\Console\Commands\MigrateFunctions;
use ResultData\ADSTools\Console\Commands\CreateStoredProcedure;
use ResultData\ADSTools\Console\Commands\MigrateStoredProcedures;

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
    }

    public function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/ads-tools.php',
            'ads-tools'
        );
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

    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/ads-tools.php' => config_path('ads-tools.php'),
            ]);
        }
    }
}
