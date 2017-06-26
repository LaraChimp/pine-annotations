<?php

namespace LaraChimp\PineAnnotations\Tests\Fixtures\Annotations;

use Doctrine\Common\Annotations\Annotation\Target;
use Doctrine\Common\Annotations\Annotation\Required;

/**
 * Some annotation.
 *
 * @Annotation
 * @Target("PROPERTY")
 */
class PropertyDoubleAnnotation
{
    /**
     * Some annotation property.
     *
     * @Required
     * @var string
     */
    public $bar;
}
