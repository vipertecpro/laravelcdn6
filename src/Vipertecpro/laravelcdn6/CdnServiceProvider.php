<?php

namespace Vipertecpro\laravelcdn6;

use Illuminate\Support\ServiceProvider;
use Vipertecpro\laravelcdn6\Contracts\CdnInterface;
use Vipertecpro\laravelcdn6\Providers\Contracts\ProviderInterface;
use Vipertecpro\laravelcdn6\Providers\AwsS3Provider;
use Vipertecpro\laravelcdn6\Contracts\AssetInterface;
use Vipertecpro\laravelcdn6\Contracts\FinderInterface;
use Vipertecpro\laravelcdn6\Contracts\ProviderFactoryInterface;
use Vipertecpro\laravelcdn6\Contracts\CdnFacadeInterface;
use Vipertecpro\laravelcdn6\Contracts\CdnHelperInterface;
use Vipertecpro\laravelcdn6\Validators\Contracts\ProviderValidatorInterface;
use Vipertecpro\laravelcdn6\Validators\ProviderValidator;
use Vipertecpro\laravelcdn6\Validators\Contracts\CdnFacadeValidatorInterface;
use Vipertecpro\laravelcdn6\Validators\CdnFacadeValidator;
use Vipertecpro\laravelcdn6\Validators\Contracts\ValidatorInterface;
use Vipertecpro\laravelcdn6\Validators\Validator;
use Vipertecpro\laravelcdn6\Commands\PushCommand;
use Vipertecpro\laravelcdn6\Commands\EmptyCommand;

/**
 * Class CdnServiceProvider.
 *
 * @category Service Provider
 *
 * @author  Vipul Walia <vipertecpro@gmail.com>
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
            CdnInterface::class,
            Cdn::class
        );

        $this->app->bind(
            ProviderInterface::class,
            AwsS3Provider::class
        );

        $this->app->bind(
            AssetInterface::class,
            Asset::class
        );

        $this->app->bind(
            FinderInterface::class,
            Finder::class
        );

        $this->app->bind(
            ProviderFactoryInterface::class,
            ProviderFactory::class
        );

        $this->app->bind(
            CdnFacadeInterface::class,
            CdnFacade::class
        );

        $this->app->bind(
            CdnHelperInterface::class,
            CdnHelper::class
        );

        $this->app->bind(
            ProviderValidatorInterface::class,
            ProviderValidator::class
        );

        $this->app->bind(
            CdnFacadeValidatorInterface::class,
            CdnFacadeValidator::class
        );

        $this->app->bind(
            ValidatorInterface::class,
            Validator::class
        );

        // register the commands:
        //-----------------------
        $this->app->singleton('cdn.push', function ($app) {
            return $app->make(PushCommand::class);
        });

        $this->commands('cdn.push');

        $this->app->singleton('cdn.empty', function ($app) {
            return $app->make(EmptyCommand::class);
        });

        $this->commands('cdn.empty');

        // facade bindings:
        //-----------------

        // Register 'CdnFacade' instance container to our CdnFacade object
        $this->app->singleton('CDN', static function ($app) {
            return $app->make(CdnFacade::class);
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
