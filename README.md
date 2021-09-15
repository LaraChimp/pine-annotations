<h2 align="center">
   <img src="https://raw.githubusercontent.com/LaraChimp/art-work/master/packages/pine-annotations/pine-annotations.png"> 
   Pine Annotations
</h2>

<p align="center">
    <a href="https://packagist.org/packages/larachimp/pine-annotations"><img src="https://poser.pugx.org/larachimp/pine-annotations/v/stable" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/larachimp/pine-annotations"><img src="https://poser.pugx.org/larachimp/pine-annotations/v/unstable" alt="Latest Unstable Version"></a>
    <a href="https://travis-ci.org/LaraChimp/pine-annotations"><img src="https://travis-ci.org/LaraChimp/pine-annotations.svg?branch=master" alt="Build Status"></a>
    <a href="https://styleci.io/repos/93665900"><img src="https://styleci.io/repos/93665900/shield?branch=master" alt="StyleCI"></a>
    <a href="https://packagist.org/packages/larachimp/pine-annotations"><img src="https://poser.pugx.org/larachimp/pine-annotations/license" alt="License"></a>
    <a href="https://packagist.org/packages/larachimp/pine-annotations"><img src="https://poser.pugx.org/larachimp/pine-annotations/downloads" alt="Total Downloads"></a>
    <a href="https://insight.sensiolabs.com/projects/88bb99bb-eb3e-4d68-bfd6-912da35c6d87" alt="medal"><img src="https://insight.sensiolabs.com/projects/88bb99bb-eb3e-4d68-bfd6-912da35c6d87/mini.png"></a>
</p>

## Introduction
Pine Annotations package makes creating and reading annotations seamlessly in any laravel 5
project. Behind the scenes Pine Annotations make use of the doctrine-annotations 
project, but tries to simplify its integration with Laravel 5.

## License
Pine Annotations is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Version Compatibility

 Laravel  | Pine Annotations
:---------|:-----------------
 5.x.x    | 0.x
 6.x      | 1.x
 7.x      | 2.x
 8.x      | 3.x

### Installation

```bash
$ composer require larachimp/pine-annotations
```

### Configuration
> If you are using Laravel >= 5.5, you can skip service registration 
> thanks to Laravel auto package discovery feature.


After installation all you need is to register the ```LaraChimp\PineAnnotations\PineAnnotationsServiceProvider``` 
in your `config/app.php` configuration file:

```php
'providers' => [
    ...
    LaraChimp\PineAnnotations\PineAnnotationsServiceProvider::class,
],
```

You can also register the ```Reader``` alias which helps in reading object's annotations.

```php
'aliases' => [
    ...
    'AnnotationsReader' => LaraChimp\PineAnnotations\Facades\Reader::class,
]
```

You can now publish config using the command:

```bash
$ php artisan vendor:publish
```

This will create the file ```pine-annotations.php``` in your config directory.

### Registering your annotations in the AnnotationRegistry

The config file ```pine-annotations.php``` has two sections ```autoload_files``` and ```autoload_namespaces```.

#### autoload_files

```php
'autoload_files' => [
    app_path('Annotations/FooAnnotation.php'),
],
```

In this array you may include the file paths of all your annotations classes. These will get registered in the ```AnnotationRegistry```. You
can include as many files as you need.

#### autoload_namespaces

```php
'autoload_namespaces' => [
    'App\Annotations',
],
```

This array contains the namespaces of your annotations classes. This is useful if you want to register all annotations classes 
of a whole namespace in a single go. 

#### Using the Reader to manually add entries to the Registry.

Alternatively you may use the methods ```addFilesToRegistry()``` and ```addNamespacesToRegistry()``` to perform manual entries of
files and namespaces to the annotation registry. 

```php
// Adding files manually to the Registry.
AnnotationsReader::addFilesToRegistry($filesPaths);
```

```php
// Adding namespaces manually to the Registry.
AnnotationsReader::addNamespacesToRegistry($namespaces);
```

> It is imperative that you register your annotations classes in one way or the other with the Reader.
> Otherwise AnnotationsReader won't be able to parse them. 

### The AnnotationsReader

To create an instance of the ```AnnotationsReader```, use the Laravel's IOC to either inject or create it via the 
```app()``` method or ```App``` facade:

```php
<?php

use LaraChimp\PineAnnotations\Support\Reader\AnnotationsReader;

class MyService 
{
    /**
     * AnnotationsReader instance.
     * 
     * @var AnnotationsReader
     */
    protected $annotationsReader;
   
    /**
     * Constructor.
     * 
     * @var AnnotationsReader $annotationsReader
     */
    public function __construct(AnnotationsReader $annotationsReader) 
    {
        $this->annotationsReader = $annotationsReader;
    }
}
```

or:

```php
$annotationsReader = app(\LaraChimp\PineAnnotations\Support\Reader\AnnotationsReader::class);
```

Alternatively can also use the ```AnnotationsReader``` facade ```LaraChimp\PineAnnotations\Facades\Reader::class``` for all
annotations reading.

### Reading all annotations of a class

Consider the following class which is annotated with the ```FooAnnotation```:

```php
<?php

/**
 * Class Baz.
 *
 * @FooAnnotation(bar="Percy")
 */
class Baz
{
    //
}
```

To read this class' annotations, simply create an instance of the ```AnnotationsReader``` with target as class :

```php
// Read all class annotations on class.
$annotations = AnnotationsReader::target('class')->read(Baz::class);
```

The ```AnnotationsReader``` will return a ```Collection``` of the class' annotations with their values filled in
the correct attributes :

```php
Illuminate\Support\Collection {
  #items: array:1 [
    0 => FooAnnotation {
      +bar: "Percy"
    }
  ]
}
```

> Note that all annotations are cached by default for convinience. Hence the AnnotationsReader does not have to parse doc blocks
> each time it reads annotations from a target, which would be rather costly operation otherwise. The AnnotationsReader uses
> the default cache which you define in your Laravel App.

### Reading a specific annotation of a class

Consider the following class which is annotated with the ```FooAnnotation``` and ```FooDoubleAnnotation``` :

```php
<?php

/**
 * Class Baz.
 *
 * @FooAnnotation(bar="Percy")
 * @FooDoubleAnnotation(bar="Mamedy")
 */
class Baz
{
    //
}
```

Now we may want to only parse or read the ```@FooDoubleAnnotation(bar="Mamedy")``` doc block. To do so, we can use the ```only()```
method on our ```AnnotationsReader``` instance. The ```only()``` method takes as a single argument the annotation's class name :

```php
// Read specific class annotations on class.
$annotations = AnnotationsReader::target('class')->only(FooDoubleAnnotation::class)->read(Baz::class);
```

This will return ```Collection``` with the keys and values of the targetted annotation:

```php
Illuminate\Support\Collection {
  #items: array:1 [
    "bar" => "Mamedy"
  ]
}
```

### Reading all annotations of a property on a class

Consider the following class with the given annotations blocks on the ```name``` property:

```php
<?php

class Baz
{
    /**
     * Name.
     *
     * @PropertyAnnotation(bar="Jeffrey")
     * @PropertyDoubleAnnotation(bar="Way")
     *
     * @var string
     */
    protected $name = '';
    
    //
}
```

To read the annotations of the ```name``` property, we will use the target as ```property``` and the property's name 
on the ```AnnotationsReader``` :

```php
// Read all class annotations on property.
$annotations = AnnotationsReader::target('property', 'name')->read(Baz::class);
```

The result is a ```Collection``` with all Annotations objects and theirs properties values filled in :

```php
Illuminate\Support\Collection {
  #items: array:2 [
    0 => PropertyAnnotation {
      +bar: "Jeffrey"
    }
    1 => PropertyDoubleAnnotation {
      +bar: "Way"
    }
  ]
}
```

### Reading specific annotation of a property on a class

Consider the following class with the given annotations blocks on the ```name``` property:

```php
<?php

class Baz
{
    /**
     * Name.
     *
     * @PropertyAnnotation(bar="Jeffrey")
     * @PropertyDoubleAnnotation(bar="Way")
     *
     * @var string
     */
    protected $name = '';
    
    //
}
```

Now we may want to only parse or read the ```@PropertyDoubleAnnotation(bar="Way")``` doc block. To do so, we will use the target as ```property``` together
with the property's name and the ```only()``` method on our ```AnnotationsReader``` instance. The ```only()``` method takes as a single argument 
the annotation's class name :

```php
// Read all class annotations on property.
$annotations = AnnotationsReader::target('property', 'name')->only(PropertyDoubleAnnotation::class)
                                                            ->read(Baz::class);
```

This will return ```Collection``` with the keys and values of the targetted annotation:

```php
Illuminate\Support\Collection {
  #items: array:1 [
    "bar" => "Way"
  ]
}
```

### Reading all annotations of a method on a class

Consider the following class with the given annotations blocks on the ```someMethod()``` method :

```php
<?php

class Baz
{  
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
}
```

To read all the annotations of the ```someMethod()``` method, we will use target as ```method``` and the method's name 
on our ```AnnotationsReader``` instance :

```php
// Read all class annotations on property.
$annotations = AnnotationsReader::target('method', 'someMethod')->read(Baz::class);
```

The result is a ```Collection``` with all Annotations objects and theirs properties values filled in :

```php
Illuminate\Support\Collection {
  #items: array:2 [
    0 => MethodAnnotation {
      +bar: "Way"
    }
    1 => MethodDoubleAnnotation {
      +bar: "Otwell"
    }
  ]
}
```

### Reading a specific annotation of a method on a class

Consider the following class with the given annotations blocks on the ```someMethod()``` method :

```php
<?php

class Baz
{  
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
}
```

Now we may want to only parse or read the ```@MethodDoubleAnnotation(bar="Otwell")``` doc block. To do so, we will use the target as ```method``` together
with the method's name and the ```only()``` method on our ```AnnotationsReader``` instance. The ```only()``` method takes as a single argument 
the annotation's class name :

```php
// Read all class annotations on property.
$annotations = AnnotationsReader::target('method', 'someMethod')->only(MethodDoubleAnnotation::class)
                                                                ->read(Baz::class);
```

This will return ```Collection``` with the keys and values of the targetted annotation:

```php
Illuminate\Support\Collection {
  #items: array:1 [
    "bar" => "Otwell"
  ]
}
```

### Credits
Big Thanks to all developers who worked hard to create something amazing!

[![LaraChimp](https://img.shields.io/badge/Author-LaraChimp-blue.svg?style=flat-square)](https://github.com/LaraChimp)

#### Creator
Twitter: [@PercyMamedy](https://twitter.com/PercyMamedy)

GitHub: [percymamedy](https://github.com/percymamedy)
