<?php

namespace LaraChimp\PineAnnotations\Tests;

use Orchestra\Testbench\TestCase;
use LaraChimp\PineAnnotations\PineAnnotationsServiceProvider;

abstract class AbstractTestCase extends TestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            PineAnnotationsServiceProvider::class,
        ];
    }
}
