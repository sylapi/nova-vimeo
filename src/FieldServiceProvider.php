<?php

namespace Sylapi\Vimeo;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Route;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $config_path = dirname(__DIR__).'/config/vimeo.php';

        $this->publishes(
            [$config_path => config_path('vimeo.php')],
            'config'
        );

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('vimeo', __DIR__.'/../dist/js/field.js');
            Nova::style('vimeo', __DIR__.'/../dist/css/field.css');
        });
    }

   /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */

     protected function routes()
     {
         Route::prefix('/nova-vendor/sylapi/vimeo')
             ->group(
                 __DIR__.'/../routes/api.php'
             );
     }    
}
