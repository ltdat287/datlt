<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('vp_email', function($attribute, $value, $parameters) {
            if (filter_var($value, FILTER_VALIDATE_EMAIL) || $value == VP_EMAIL_DEFAULT)
            {
                return true;
            }
        
            return true;
        });
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
