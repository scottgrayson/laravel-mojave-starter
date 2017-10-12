<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Form::component(
            'bs',
            'form.inputs.auto',
            [
            'name',
            'type' => null,
            'value' => null,
            'attributes' => [],
            'rules' => [],
            'item' => null,
            ]
        );

        \Form::component(
            'relation',
            'form.inputs.relation',
            [
            'name',
            'value' => null,
            'relation' => null,
            'attributes' => [],
            'item' => null,
            ]
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
