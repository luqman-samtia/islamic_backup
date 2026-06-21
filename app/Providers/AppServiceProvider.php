<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        Schema::defaultStringLength(191);
        // In a service provider or dedicated view composer
        View::composer('adminlte::page', function ($view) {
            if (auth()->check()) {
                $logo = '<b>Admin</b>LTE'; 
                $logoMini = '<b>A</b>LT'; 
                
                if (auth()->user()->type === 'admin') {
                    $logo = '<b>Admin</b> Dashboard';
                    $logoMini = '<b>A</b>D';
                } elseif (auth()->user()->type === 'student') {
                    $logo = '<b>Student</b> Dashboard';
                    $logoMini = '<b>S</b>D';
                }
                elseif ( auth()->user()->type === 'scholar') {
                    $logo = '<b>Scholar</b> Dashboard';
                    $logoMini = '<b>S</b>D';
                }
                
                config(['adminlte.logo' => $logo]);
                config(['adminlte.logo_mini' => $logoMini]);

            }
        });
    }
}
