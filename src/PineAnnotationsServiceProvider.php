<?php

namespace LaraChimp\PineAnnotations;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\Reader;
use Illuminate\Support\ServiceProvider;
use LaraChimp\PineAnnotations\Doctrine\Cache\LaravelCacheDriver;
use LaraChimp\PineAnnotations\Support\Reader\AnnotationsReader;

class PineAnnotationsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/pine-annotations.php' => config_path('pine-annotations.php'),
        ]);

        $this->addAnnotationsToRegistry();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Merge Configs.
        $this->mergeConfigFrom(
            __DIR__.'/../config/pine-annotations.php', 'pine-annotations'
        );

        // Register annotations reader.
        $this->registerReader();

        // Register commands.
        $this->registerCommands();
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
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
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

    /**
     * Add files and namespaces to the annotations registry.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function addAnnotationsToRegistry()
    {
        // Creates annotation Reader.
        $reader = $this->app->make(AnnotationsReader::class);

        // Register files autoload.
        $reader->addFilesToRegistry(config('pine-annotations.autoload_files'));

        // Register namespaces autoload.
        $reader->addNamespacesToRegistry(config('pine-annotations.autoload_namespaces'));
    }
}
