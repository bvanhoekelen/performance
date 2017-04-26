# PHP Performance tool

[![Hex.pm](https://img.shields.io/hexpm/l/plug.svg?maxAge=2592000&style=flat-square)](https://github.com/bvanhoekelen/performance/blob/master/LICENSE)
[![Packagist Prerelease](https://img.shields.io/packagist/vpre/bvanhoekelen/performance.svg?style=flat-square)](https://packagist.org/packages/bvanhoekelen/performance)
[![Packagist](https://img.shields.io/packagist/dt/bvanhoekelen/performance.svg?style=flat-square)](https://packagist.org/packages/bvanhoekelen/performance)
[![Github issues](https://img.shields.io/github/issues/bvanhoekelen/performance.svg?style=flat-square)](https://github.com/bvanhoekelen/performance/issues)
[![Travis branch](https://img.shields.io/travis/bvanhoekelen/performance/master.svg?style=flat-square)](https://travis-ci.org/bvanhoekelen/performance)
[![Travis branch](https://img.shields.io/travis/bvanhoekelen/performance/develop.svg?style=flat-square)](https://travis-ci.org/bvanhoekelen/performance) Build: Master|Develop

<p align="center"><img src="/assets/raw/php-performance-tool.png" alt="PHP performance tool" /></p>

## Highlight
- Measure easily the performance of your PHP script across multiple platforms
- Support for Laravel framework » [Laravel](https://laravel.com)
- Support interface web, web console and command line
- Export results to class, file or json string
- Print information about PHP version, max exaction time and max memory
- Measure time, memory usage and memory peak
- Switch automatically between interfaces
- Live function » [how to use](#command-line)
- Easy to install » [installation](#installation)
- Clearly and active wiki » [Wiki](https://github.com/bvanhoekelen/performance/wiki)
- Love feedback » [backlog](https://github.com/bvanhoekelen/performance/blob/master/BACKLOG.md) or [create issues](https://github.com/bvanhoekelen/performance/issues)

## Easy to use
```php
// Add namespace at the top
use Performance\Performance;

// Set measure point
Performance::point();

//
// Run test code
//

// Finish all tasks and show test results
Performance::results();

```

## Web preview
<p align="center"><img src="/assets/raw/php-performance-tool-web-support.png" alt="PHP performance tool for web" /></p>

## Command line preview
<p align="center"><img src="/assets/raw/php-performance-tool-command-line.png" alt="PHP performance tool for command line" /></p>

## Functions
Set measuring point with or without label

```php
Performance::point( <optional:label> );
```

Finish previous measuring point 

```php
Performance::finish();
```

See the [function overview](/bvanhoekelen/performance/wiki/Doc-functions) for more.

Finish all measuring points and return test results

```php
Performance::results();
```

## Command line

Run the performance test for the command line

```php
// Normal
$ php your_script.php

// Or Live version
$ php your_script.php --live 
```

# Help, docs and links
- [Wiki](https://github.com/bvanhoekelen/performance/wiki)
- [Backlog](https://github.com/bvanhoekelen/performance/blob/master/BACKLOG.md)
- [Change log](https://github.com/bvanhoekelen/performance/blob/master/CHANGELOG.md)
- [Packagist](https://packagist.org/packages/bvanhoekelen/performance)

## Backlog & Feedback
If you have any suggestions to improve this performance tool? Please add your feature, bug or improvement to the [BACKLOG.dm](https://github.com/bvanhoekelen/performance/blob/master/BACKLOG.md). Or create a [issues](https://github.com/bvanhoekelen/performance/issues).
- [Open backlog](https://github.com/bvanhoekelen/performance/blob/master/BACKLOG.md)
- [Create issues](https://github.com/bvanhoekelen/performance/issues)

# Installation

## Install with Laravel
Get PHP performance tool by running the Composer command in the command line. 
```{r, engine='bash', count_lines}
 $ composer require bvanhoekelen/performance
```

Open your file for the performance test.
```php
// Add namespace at the top
use Performance\Performance;

// Set measure point
Performance::point();

//
// Run test code
//

// Finish all tasks and show test results
Performance::results();
```

## Install with Composer
Get PHP performance by running the Composer command in the command line. 
```{r, engine='bash', count_lines}
 $ composer require bvanhoekelen/performance
```

Open your file for the performance test.
```php
// Require vender autoload
require_once('../vendor/autoload.php');

// Add namespace at the top
use Performance\Performance;

// Set measure point
Performance::point();

//
// Run test code
//

// Finish all tasks and show test results
Performance::results();
```
