<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Blade::component('components.badge', 'badge');
        //Bla::component('views.components.errors', 'errors');

    Schema::defaultStringLength(191);
        view()->composer(['Posts.index','Posts.show'],ActivityComposer::class);
    }
}
