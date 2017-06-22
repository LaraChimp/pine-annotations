<?php

namespace LaraChimp\PineAnnotations\Facades;

use Illuminate\Support\Facades\Facade;
use LaraChimp\PineAnnotations\Support\Reader\AnnotationsReader;

class Reader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AnnotationsReader::class;
    }
}
