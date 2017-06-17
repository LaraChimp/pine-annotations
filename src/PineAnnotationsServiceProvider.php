<?php

namespace LaraChimp\PineAnnotations;

use Illuminate\Foundation\Application;
use Doctrine\Common\Annotations\Reader;
use Illuminate\Support\ServiceProvider;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\AnnotationReader;
use LaraChimp\PineAnnotations\Support\Reader\AnnotationsReader;
use LaraChimp\PineAnnotations\Doctrine\Cache\LaravelCacheDriver;

class PineAnnotationsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Register Laravel Doctrine Cache annotations
        // cache driver.
        $this->registerDoctrineCacheDriver();

        // Register annotations reader.
        $this->registerReader();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            AnnotationsReader::class,
            LaravelCacheDriver::class,
        ];
    }

    /**
     * Registers Doctrine Cache driver for Laravel.
     *
     * @return void
     */
    protected function registerDoctrineCacheDriver()
    {
        $this->app->bind(LaravelCacheDriver::class, function (Application $app) {
            return new LaravelCacheDriver($app->make('cache'));
        });
    }

    /**
     * Registers the Annotations reader.
     *
     * @return void
     */
    protected function registerReader()
    {
        $this->app->when(AnnotationsReader::class)
                  ->needs(Reader::class)
                  ->give(function (Application $app) {
                      // Give a Cached Reader when our
                      // reader class needs
                      // a ReaderContract.
                      return new CachedReader(
                          new AnnotationReader(),
                          $app->make(LaravelCacheDriver::class),
                          (bool) config('app.debug')
                      );
                  });
    }
}
