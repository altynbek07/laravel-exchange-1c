<?php

namespace Altynbek07\Exchange1C;

use Altynbek07\Exchange1C\Interfaces\EventDispatcherInterface;
use Altynbek07\Exchange1C\Interfaces\ModelBuilderInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

/**
 * Class Exchange1CServiceProvider.
 */
class Exchange1CServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // config
        $this->publishes([__DIR__ . '/../config/' => config_path()], 'config');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(Config::class, function ($app) {
            return new Config($app['config']['exchange-1c']);
        });

        $this->app->singleton(EventDispatcherInterface::class, function ($app) {
            $laravelDispatcher = $app[Dispatcher::class];

            return new LaravelEventDispatcher($laravelDispatcher);
        });

        $this->app->singleton(ModelBuilderInterface::class, function ($app) {
            return $app[ModelBuilder::class];
        });
    }
}
