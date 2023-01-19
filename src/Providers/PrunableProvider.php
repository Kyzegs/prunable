<?php

namespace Kyzegs\Prunable\Providers;

use Illuminate\Support\ServiceProvider;
use Kyzegs\Prunable\Console\Commands\PruneCommand;

class PrunableProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend(\Illuminate\Database\Console\PruneCommand::class, fn () => new PruneCommand());
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([PruneCommand::class]);
        }
    }
}
