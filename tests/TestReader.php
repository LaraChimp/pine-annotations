<?php

namespace LaraChimp\PineAnnotations\Tests;

use Illuminate\Support\Collection;
use LaraChimp\PineAnnotations\Support\Reader\AnnotationsReader;
use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\FooAnnotation;
use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\FooDoubleAnnotation;
use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\MethodAnnotation;
use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\MethodDoubleAnnotation;
use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\PropertyAnnotation;
use LaraChimp\PineAnnotations\Tests\Fixtures\Annotations\PropertyDoubleAnnotation;
use LaraChimp\PineAnnotations\Tests\Fixtures\Baz;
use LaraChimp\PineAnnotations\Tests\Fixtures\BazDouble;

class TestReader extends AbstractTestCase
{
    /**
     * Test that we can properly read annotations
     * for a given class.
     *
     * @return void
     */
    public function testReadingAllAnnotationsForAClass()
    {
        // Read all class annotations on class.
        /** @var Collection $annotations */
        $annotations = $this->app->make(AnnotationsReader::class)
                                 ->target('class')
                                 ->read(Baz::class);

        $this->assertInstanceOf(Collection::class, $annotations);
        $this->assertInstanceOf(FooAnnotation::class, $annotations->first());
        $this->assertEquals('Percy', $annotations->first()->bar);
    }

    /**
     * Test that for a class we are able to read the specific
     * annotations for it.
     *
     * @return void
     */
    public function testReadingSpecificAnnotationForAClass()
    {
        // Read specific class annotations on class.
        /** @var Collection $annotations */
        $annotations = $this->app->make(AnnotationsReader::class)
                                 ->target('class')
                                 ->only(FooDoubleAnnotation::class)
                                 ->read(BazDouble::class);

        $this->assertInstanceOf(Collection::class, $annotations);
        $this->assertEquals('Mamedy', $annotations['bar']);
    }

    /**
     * Test that we are able to read all the properties annotations
     * for the given class.
     *
     * @return void
     */
    public function testReadingAllPropertiesAnnotations()
    {
        // Read all property annotations on class.
        /** @var Collection $annotations */
        $annotations = $this->app->make(AnnotationsReader::class)
                                 ->target('property', 'name')
                                 ->read(Baz::class);

        $this->assertInstanceOf(Collection::class, $annotations);

        $this->assertInstanceOf(PropertyAnnotation::class, $annotations[0]);
        $this->assertInstanceOf(PropertyDoubleAnnotation::class, $annotations[1]);

        $this->assertEquals('Desire', $annotations[0]->bar);
        $this->assertEquals('Jeffrey', $annotations[1]->bar);
    }

    /**
     * Test that we can read single annotation for a property.
     *
     * @return void
     */
    public function testReadingSingleAnnotationOnProperty()
    {
        // Read specify property annotations on class.
        /** @var Collection $annotations */
        $annotations = $this->app->make(AnnotationsReader::class)
                                 ->target('property', 'text')
                                 ->only(PropertyDoubleAnnotation::class)
                                 ->read(Baz::class);

        $this->assertInstanceOf(Collection::class, $annotations);
        $this->assertEquals('Taylor', $annotations['bar']);
    }

    /**
     * Test that we can read all annotations present on
     * a method.
     *
     * @return void
     */
    public function testReadingAllAnnotationsOnMethod()
    {
        // Read all method annotations on class.
        /** @var Collection $annotations */
        $annotations = $this->app->make(AnnotationsReader::class)
                                 ->target('method', 'someMethod')
                                 ->read(Baz::class);

        $this->assertInstanceOf(Collection::class, $annotations);

        $this->assertInstanceOf(MethodAnnotation::class, $annotations[0]);
        $this->assertInstanceOf(MethodDoubleAnnotation::class, $annotations[1]);

        $this->assertEquals('Way', $annotations[0]->bar);
        $this->assertEquals('Otwell', $annotations[1]->bar);
    }

    /**
     * Test that we can read a specific annotation block
     * on a method.
     *
     * @return void
     */
    public function testReadingSingleAnnotationOnMethod()
    {
        // Read specific method annotations on class.
        /** @var Collection $annotations */
        $annotations = $this->app->make(AnnotationsReader::class)
                                 ->target('method', 'someMethod')
                                 ->only(MethodDoubleAnnotation::class)
                                 ->read(Baz::class);

        $this->assertInstanceOf(Collection::class, $annotations);
        $this->assertEquals('Otwell', $annotations['bar']);
    }
}
