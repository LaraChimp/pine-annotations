<?php

namespace LaraChimp\PineAnnotations;

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
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Register annotations reader.
        $this->registerReader();
        // Register commands.
        $this->registerCommands();
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
        ];
    }

    /**
     * Registers the Annotations reader.
     *
     * @return void
     */
    protected function registerReader()
    {
        // Give a Cached Reader when our
        // reader class needs
        // a ReaderContract.
        $this->app->when(AnnotationsReader::class)
                  ->needs(Reader::class)
                  ->give(function () {
                      return $this->createAndReturnCachedReader();
                  });
    }

    /**
     * Creates and returns a cached reader for
     * reading annotations.
     *
     * @return CachedReader
     */
    protected function createAndReturnCachedReader()
    {
        return new CachedReader(
            new AnnotationReader(),
            $this->app->make(LaravelCacheDriver::class),
            (bool) config('app.debug')
        );
    }

    /**
     * Registers PineAnnotations Commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        // Make sure we are running in console
        // then we registers commands.
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\MakeAnnotationCommand::class,
            ]);
        }
    }
}
