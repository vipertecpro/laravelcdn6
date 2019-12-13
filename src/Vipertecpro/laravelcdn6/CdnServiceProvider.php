<?php

namespace Vipertecpro\laravelcdn6;

use Illuminate\Support\ServiceProvider;

/**
 * Class CdnServiceProvider.
 *
 * @category Service Provider
 *
 * @author  Mahmoud Zalt <mahmoud@vinelab.com>
 * @author  Abed Halawi <abed.halawi@vinelab.com>
 */
class CdnServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/cdn.php' => config_path('cdn.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        // implementation bindings:
        //-------------------------
        $this->app->bind(
            'Vipertecpro\laravelcdn6\Contracts\CdnInterface',
            'Vipertecpro\laravelcdn6\Cdn'
        );

        $this->app->bind(
            'Vipertecpro\laravelcdn6\Providers\Contracts\ProviderInterface',
            'Vipertecpro\laravelcdn6\Providers\AwsS3Provider'
        );

        $this->app->bind(
            'Vipertecpro\laravelcdn6\Contracts\AssetInterface',
            'Vipertecpro\laravelcdn6\Asset'
        );

        $this->app->bind(
            'Vipertecpro\laravelcdn6\Contracts\FinderInterface',
            'Vipertecpro\laravelcdn6\Finder'
        );

        $this->app->bind(
            'Vipertecpro\laravelcdn6\Contracts\ProviderFactoryInterface',
            'Vipertecpro\laravelcdn6\ProviderFactory'
        );

        $this->app->bind(
            'Vipertecpro\laravelcdn6\Contracts\CdnFacadeInterface',
            'Vipertecpro\laravelcdn6\CdnFacade'
        );

        $this->app->bind(
            'Vipertecpro\laravelcdn6\Contracts\CdnHelperInterface',
            'Vipertecpro\laravelcdn6\CdnHelper'
        );

        $this->app->bind(
            'Vipertecpro\laravelcdn6\Validators\Contracts\ProviderValidatorInterface',
            'Vipertecpro\laravelcdn6\Validators\ProviderValidator'
        );

        $this->app->bind(
            'Vipertecpro\laravelcdn6\Validators\Contracts\CdnFacadeValidatorInterface',
            'Vipertecpro\laravelcdn6\Validators\CdnFacadeValidator'
        );

        $this->app->bind(
            'Vipertecpro\laravelcdn6\Validators\Contracts\ValidatorInterface',
            'Vipertecpro\laravelcdn6\Validators\Validator'
        );

        // register the commands:
        //-----------------------
        $this->app->singleton('cdn.push', function ($app) {
            return $app->make('Vipertecpro\laravelcdn6\Commands\PushCommand');
        });

        $this->commands('cdn.push');

        $this->app->singleton('cdn.empty', function ($app) {
            return $app->make('Vipertecpro\laravelcdn6\Commands\EmptyCommand');
        });

        $this->commands('cdn.empty');

        // facade bindings:
        //-----------------

        // Register 'CdnFacade' instance container to our CdnFacade object
        $this->app->singleton('CDN', function ($app) {
            return $app->make('Vipertecpro\laravelcdn6\CdnFacade');
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
//        $this->app->booting(function () {
//            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
//            $loader->alias('Cdn', 'Vipertecpro\laravelcdn6\Facades\CdnFacadeAccessor');
//        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
