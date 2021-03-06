<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production', 'staging')) {
            $this->app->register(\Rollbar\Laravel\RollbarServiceProvider::class);
        }

        \App\Newsletter::observe(\App\Observers\NewsletterObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
