<?php

namespace Whitwhoa\LaravelSubAuth;

use Illuminate\Support\ServiceProvider;

class LaravelSubAuthServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'whitwhoa');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'whitwhoa');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->app['router']->namespace('Whitwhoa\\LaravelSubAuth\\Controllers')
            ->middleware(['web'])
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            });

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravelsubauth.php', 'laravelsubauth');

        // Register the service the package provides.
        $this->app->singleton('laravelsubauth', function ($app) {
            return new SubAuth();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelsubauth'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravelsubauth.php' => config_path('laravelsubauth.php'),
        ], 'laravelsubauth.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/whitwhoa'),
        ], 'laravelsubauth.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/whitwhoa'),
        ], 'laravelsubauth.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/whitwhoa'),
        ], 'laravelsubauth.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
