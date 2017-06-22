<?php

namespace LaraChimp\PineAnnotations\Tests;

use Illuminate\Support\Collection;
use LaraChimp\PineAnnotations\Tests\Fixtures\Baz;
use LaraChimp\PineAnnotations\Tests\Fixtures\FooAnnotation;
use LaraChimp\PineAnnotations\Support\Reader\AnnotationsReader;

class TestReader extends AbstractTestCase
{
    /**
     * Test that we can properly read annotations
     * for a given class.
     *
     * @return void
     */
    public function testReadingAnnotationsForAClass()
    {
        // Create new Baz.
        $baz = new Baz();

        // Read annotations on object.
        /** @var Collection $annotations */
        $annotations = $this->app->make(AnnotationsReader::class)->read($baz);

        $this->assertInstanceOf(Collection::class, $annotations);
        $this->assertInstanceOf(FooAnnotation::class, $annotations->first());
        $this->assertEquals('Percy', $annotations->first()->bar);
    }
}
