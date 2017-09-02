<?php

namespace LaraChimp\PineAnnotations\Support\Reader;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Finder\Finder;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use LaraChimp\PineAnnotations\Concerns\NamespaceToPathConvertable;

class AnnotationsReader
{
    use NamespaceToPathConvertable;

    /**
     * The Reader instance.
     *
     * @var Reader
     */
    protected $reader;

    /**
     * What target should we get from the reader.
     * Values include 'class', 'method', 'property'.
     *
     * @var string
     */
    protected $target = 'class';

    /**
     * Name of the Property or Method to target.
     *
     * @var string
     */
    protected $keyName = null;

    /**
     * The name of the annotation.
     *
     * @var string|null
     */
    protected $annotationName = null;

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
     * Which type of annotation should the reader target.
     * The default is class.
     *
     * @param string $target
     * @param string $keyName
     *
     * @return self
     */
    public function target($target, $keyName = null)
    {
        $this->target = $target;
        $this->keyName = $keyName;

        return $this;
    }

    /**
     * The annotation name if any to target.
     *
     * @param string $annotationName
     *
     * @return $this
     */
    public function only($annotationName)
    {
        $this->annotationName = $annotationName;

        return $this;
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
        // Get Reflection.
        $reflection = $this->getReflectionFrom($argument);

        // We have some specific annotations to be read.
        if ($this->wantsSpecificAnnotation()) {
            return $this->readSpecificAnnotationFor($reflection);
        }

        // We require to read all annotations.
        return $this->readAllAnnotationsFor($reflection);
    }

    /**
     * Adds files containing annotations to the registry.
     *
     * @param array|string $filePaths
     *
     * @return self
     */
    public function addFilesToRegistry($filePaths)
    {
        collect((array) $filePaths)->each(function ($filePath) {
            if (file_exists($filePath)) {
                AnnotationRegistry::registerFile($filePath);
            }
        });

        return $this;
    }

    /**
     * Adds namespaces containing annotations to the registry.
     *
     * @param array|string $namespaces
     *
     * @return $this
     */
    public function addNamespacesToRegistry($namespaces)
    {
        collect((array) $namespaces)->each(function ($namespace) {
            // Get path from namespace.
            $path = $this->getPathFromNamespace($namespace);

            if (file_exists($path)) {
                // Register each annotations file found in the namespace.
                foreach (Finder::create()->files()->name('*.php')->in($path) as $file) {
                    $this->addFilesToRegistry($file->getRealPath());
                }
            }
        });

        return $this;
    }

    /**
     * Reads all the annotations for the given target.
     *
     * @param ReflectionClass|ReflectionProperty|ReflectionMethod $reflection
     *
     * @return \Illuminate\Support\Collection
     */
    protected function readAllAnnotationsFor($reflection)
    {
        // Construct Method to be used for reading.
        $methodName = $this->constructReadMethod();

        // Read, Collect and return annotations.
        return collect($this->reader->{$methodName}($reflection));
    }

    /**
     * Reads the specified annotation name given for the target.
     *
     * @param ReflectionClass|ReflectionProperty|ReflectionMethod $reflection
     *
     * @return \Illuminate\Support\Collection
     */
    protected function readSpecificAnnotationFor($reflection)
    {
        // Construct Method to be used for reading.
        $methodName = $this->constructReadMethod();

        // Read, Collect and return annotations.
        return collect($this->reader->{$methodName}($reflection, $this->annotationName));
    }

    /**
     * Get the ReflectionClass from an argument.
     * be it an object or a class name.
     *
     * @param mixed $argument
     *
     * @return ReflectionClass|ReflectionMethod|ReflectionProperty
     */
    protected function getReflectionFrom($argument)
    {
        // Method name to use.
        $reflectionMethodName = Str::camel('getreflection'.$this->target.'from');

        // Return Reflection
        return $this->{$reflectionMethodName}($argument);
    }

    /**
     * Get the ReflectionClass for a given argument.
     *
     * @param mixed $argument
     *
     * @return ReflectionClass
     */
    protected function getReflectionClassFrom($argument)
    {
        // Argument is an Object.
        if (is_object($argument)) {
            $argument = get_class($argument);
        }

        // Get Reflected class of the object.
        return new ReflectionClass($argument);
    }

    /**
     * Get the ReflectionProperty for a given argument.
     *
     * @param mixed $argument
     *
     * @throws InvalidArgumentException
     *
     * @return ReflectionProperty
     */
    protected function getReflectionPropertyFrom($argument)
    {
        // No property name is given for targetting.
        if (is_null($this->keyName)) {
            throw new InvalidArgumentException('Property name to target is required');
        }

        // Argument is an Object.
        if (is_object($argument)) {
            $argument = get_class($argument);
        }

        // Get Reflected property of the object.
        return new ReflectionProperty($argument, $this->keyName);
    }

    /**
     * Get the ReflectionMethod for a given argument.
     *
     * @param mixed $argument
     *
     * @return ReflectionMethod
     */
    protected function getReflectionMethodFrom($argument)
    {
        // No method name is given for targetting.
        if (is_null($this->keyName)) {
            throw new InvalidArgumentException('Method name to target is required');
        }

        // Argument is an Object.
        if (is_object($argument)) {
            $argument = get_class($argument);
        }

        // Get Reflected method of the object.
        return new ReflectionMethod($argument, $this->keyName);
    }

    /**
     * Gets the Method name to be used by the Reader.
     *
     * @return string
     */
    protected function constructReadMethod()
    {
        // Reader methods ends with this.
        $endsWith = 'annotations';

        // We have an annotation name which means
        // we have to target a specific one.
        if ($this->wantsSpecificAnnotation()) {
            $endsWith = 'annotation';
        }

        return Str::camel('get'.$this->target.$endsWith);
    }

    /**
     * Checks if the user wants to read
     * some specific annotation.
     *
     * @return bool
     */
    protected function wantsSpecificAnnotation()
    {
        return ! is_null($this->annotationName);
    }
}
