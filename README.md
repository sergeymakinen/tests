# Common PHPUnit tests stuff

Common tests stuff for PHPUnit tests. Compatible with PHPUnit:

- 4.8.35 or higher
- 5.4.3 or higher
- 6.0.3 or higher

I use it in my library tests but you're also free to use. :)

[![Code Quality](https://img.shields.io/scrutinizer/g/sergeymakinen/tests.svg?style=flat-square)](https://scrutinizer-ci.com/g/sergeymakinen/tests) [![Build Status](https://img.shields.io/travis/sergeymakinen/tests.svg?style=flat-square)](https://travis-ci.org/sergeymakinen/tests) [![Code Coverage](https://img.shields.io/codecov/c/github/sergeymakinen/tests.svg?style=flat-square)](https://codecov.io/gh/sergeymakinen/tests) [![SensioLabsInsight](https://img.shields.io/sensiolabs/i/972b722f-b194-4de7-9eed-24f77bc8c9e2.svg?style=flat-square)](https://insight.sensiolabs.com/projects/972b722f-b194-4de7-9eed-24f77bc8c9e2)

[![Packagist Version](https://img.shields.io/packagist/v/sergeymakinen/tests.svg?style=flat-square)](https://packagist.org/packages/sergeymakinen/tests) [![Total Downloads](https://img.shields.io/packagist/dt/sergeymakinen/tests.svg?style=flat-square)](https://packagist.org/packages/sergeymakinen/tests) [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Installation

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```bash
composer require --dev "sergeymakinen/tests:^1.0"
```

or add

```json
"sergeymakinen/tests": "^1.0"
```

to the require-dev section of your `composer.json` file.

## Usage

```php
class MyClassTest extends \SergeyMakinen\Tests\TestCase
{
    //
}
```
