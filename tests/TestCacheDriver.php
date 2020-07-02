<?php

namespace LaraChimp\PineAnnotations\Tests;

use Illuminate\Cache\CacheManager;
use Illuminate\Support\Collection;
use LaraChimp\PineAnnotations\Doctrine\Cache\LaravelCacheDriver;
use LaraChimp\PineAnnotations\Support\Reader\AnnotationsReader;
use LaraChimp\PineAnnotations\Tests\Fixtures\Baz;

class TestCacheDriver extends AbstractTestCase
{
    /**
     * Test that the cache driver is constructed
     * correctly with proper dependencies.
     *
     * @return void
     */
    public function testCacheDriverIsConstructed()
    {
        $cacheDriver = $this->app->make(LaravelCacheDriver::class);
        $this->assertInstanceOf(CacheManager::class, $cacheDriver->getCache());
    }

    /**
     * We tests that doctrine annotations will use the LaravelCache driver
     * to store annotations and that it leverages Laravel defaults cache.
     *
     * @return void
     */
    public function testLaravelCacheIsBeingUsedToStoreAnnotations()
    {
        $this->assertFalse($this->app->make('cache')->has('[LaraChimp\PineAnnotations\Tests\Fixtures\Baz][1]'));

        // Create new Baz.
        $baz = new Baz();

        // Read annotations on object.
        /* @var Collection $annotations */
        $this->app->make(AnnotationsReader::class)->read($baz);

        // Annotation is saved in Laravel's cache.
        $this->assertTrue($this->app->make('cache')->has('[LaraChimp\PineAnnotations\Tests\Fixtures\Baz][1]'));
    }
}
