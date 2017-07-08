<?php

namespace LaraChimp\PineAnnotations\Tests\Fixtures\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;
use Doctrine\Common\Annotations\Annotation\Required;

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
     * @var string
     */
    public $bar;
}
