# util

PHP functions

[![Latest Version on Packagist](https://img.shields.io/github/release/odan/util.svg)](https://github.com/odan/util/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![Build Status](https://travis-ci.org/odan/util.svg?branch=master)](https://travis-ci.org/odan/util)
[![Coverage Status](https://scrutinizer-ci.com/g/odan/util/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/odan/util/code-structure)
[![Quality Score](https://scrutinizer-ci.com/g/odan/util/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/odan/util/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/odan/util.svg)](https://packagist.org/packages/odan/util)


## Installation

```
composer require odan/util
```

## Functions

* html -  Convert all applicable characters to HTML entities.
* is_email - Validate a E-Mail address
* now - ISO date time (Y-m-d H:i:s)
* uuid - Returns a `UUID` v4 created from a cryptographically secure random value
* array_value - Return Array element value, with dot notation.
* encode_utf8 - Encodes an ISO-8859-1 string or array to UTF-8.
* encode_iso - Returns a ISO-8859-1 encoded string or array
* read - Read a php file

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
[Composer]: http://getcomposer.org/
[PHPUnit]: http://phpunit.de/