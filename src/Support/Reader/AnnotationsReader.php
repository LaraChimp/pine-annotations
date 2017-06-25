<?php

namespace LaraChimp\PineAnnotations\Support\Reader;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\Annotation\Target;

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
     * @param mixed $argument
     *
     * @return \Illuminate\Support\Collection
     */
    public function read($argument)
    {
        // Argument is an Object.
        if (is_object($argument)) {
            $argument = get_class($argument);
        }

        // Get Reflected class of the object.
        $reflClass = new \ReflectionClass($argument);

        // Return class annotations.
        return collect($this->getReader()->getClassAnnotations($reflClass));
    }

    protected function getMethodByTarget($target)
    {

    }
}
