<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GlobalVariablesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $almacenes = [];
        view()->share('almacenes', $almacenes);
    }

    public function register()
    {
        //
    }
}
