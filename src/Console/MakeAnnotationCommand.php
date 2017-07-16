<?php

namespace LaraChimp\PineAnnotations\Console;

use Illuminate\Console\GeneratorCommand;

class MakeAnnotationCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:annotation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new annotation class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Annotation';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    public function getStub()
    {
        return __DIR__.'/stubs/annotation_all.stub';
    }
}
