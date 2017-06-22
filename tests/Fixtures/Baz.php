<?php

namespace LaraChimp\PineAnnotations\Tests\Fixtures;

/**
 * Class Baz
 *
 * @FooAnnotation(bar="Percy")
 */
class Baz
{
    /**
     * Name.
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
