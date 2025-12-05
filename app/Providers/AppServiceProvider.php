<?php

namespace App\Providers;



use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
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
        Blade::component('components.admin', 'admin');
        Blade::component('components.admin.header', 'header');
        Blade::component('components.admin.card', 'card');
        Blade::component('components.admin.table', 'table');
        Blade::component('components.admin.filter', 'filter');
        Paginator::useBootstrap();
    }
}
