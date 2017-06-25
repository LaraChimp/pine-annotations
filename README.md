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

### Installation

```bash
$ composer require larachimp/pine-annotations
```

### Configuration
> If you are using Laravel >= 5.5, you can skip service registration 
> thanks to Laravel auto package discovery feature.


After installation all you need is to register the ```LaraChimp\PineAnnotations\PineAnnotationsServiceProvider``` in your `config/app.php` configuration file:

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
    'Reader' => LaraChimp\PineAnnotations\Facades\Reader::class,
]
```

### Usage

Coming soon !!

### Credits
Big Thanks to all developers who worked hard to create something amazing!

[![LaraChimp](https://img.shields.io/badge/Author-LaraChimp-blue.svg?style=flat-square)](https://github.com/LaraChimp)

#### Creator
Twitter: [@PercyMamedy](https://twitter.com/PercyMamedy)

GitHub: [percymamedy](https://github.com/percymamedy)
