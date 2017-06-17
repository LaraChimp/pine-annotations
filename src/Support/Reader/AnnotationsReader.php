<?php

namespace LaraChimp\PineAnnotations\Support\Reader;

use Doctrine\Common\Annotations\Reader;

class AnnotationsReader
{
    /**
     * The Reader instance.
     *
     * @var Reader
     */
    protected $reader;

    /**
     * Reader constructor.
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }
}
