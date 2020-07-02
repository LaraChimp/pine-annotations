<?php

namespace LaraChimp\PineAnnotations\Tests\Fixtures;

use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\FooAnnotation;
use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\MethodAnnotation;
use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\MethodDoubleAnnotation;
use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\PropertyAnnotation;
use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\PropertyDoubleAnnotation;

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
     * @PropertyAnnotation(bar="Desire")
     * @PropertyDoubleAnnotation(bar="Jeffrey")
     *
     * @var string
     */
    protected $name = '';

    /**
     * Text.
     *
     * @PropertyAnnotation(bar="Hans")
     * @PropertyDoubleAnnotation(bar="Taylor")
     *
     * @var string
     */
    protected $text = '';

    /**
     * Some method that does somethin.
     *
     * @MethodAnnotation(bar="Way")
     * @MethodDoubleAnnotation(bar="Otwell")
     *
     * @return string
     */
    public function someMethod()
    {
        return 'I did something.';
    }

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
