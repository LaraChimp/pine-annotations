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

    /**
     * Get the Reader.
     *
     * @return Reader
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * Reads annotations for a given object.
     *
     * @param mixed $object
     *
     * @return \Illuminate\Support\Collection
     */
    public function read($object)
    {
        // Get Reflected class of the object.
        $reflClass = new \ReflectionClass(get_class($object));

        // Return class annotations.
        return collect($this->getReader()->getClassAnnotations($reflClass));
    }
}
