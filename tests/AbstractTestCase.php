<?php

namespace LaraChimp\PineAnnotations\Tests;

use LaraChimp\PineAnnotations\PineAnnotationsServiceProvider;
use Orchestra\Testbench\TestCase;

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
