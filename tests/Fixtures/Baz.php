<?php

namespace LaraChimp\PineAnnotations\Tests\Fixtures;

use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\FooAnnotation;
use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\PropertyAnnotation;

/**
 * Class Baz.
 *
 * @FooAnnotation(bar="Percy")
 */
class Baz
{
    /**
     * Name.
     *
     * @PropertyAnnotation(bar="Mamedy")
     *
     * @var string
     */
    protected $name = '';

    /**
     * Sets name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
