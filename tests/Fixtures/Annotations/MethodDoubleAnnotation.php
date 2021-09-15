<?php

namespace LaraChimp\PineAnnotations\Tests\Fixtures\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Some annotation.
 *
 * @Annotation
 * @Target("METHOD")
 */
class MethodDoubleAnnotation
{
    /**
     * Some annotation property.
     *
     * @Required
     *
     * @var string
     */
    public $bar;
}
