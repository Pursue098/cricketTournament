<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\SeriesRepository::class, \App\Repositories\SeriesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StaduimRepository::class, \App\Repositories\StaduimRepositoryEloquent::class);
        //:end-bindings:
    }
}
