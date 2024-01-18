![:package](:hero)

# Macro Attributes

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-build]][link-build]

Automatically register macros and mixins on any of Laravel's core `Macroable` classes with annotations on the relevant
classes instead of in a service provider.

## Installation
You can install `cove/macro-attributes` via [Composer](http://getcomposer.org):

```bash
composer require cove/macro-attributes
```

### Registering the service provider
Ensure the `ServiceProvider` is registered in your application, either by auto-discovery, or by adding it to your 
`providers` array in `config/app.php` manually:

```php
'providers' => [
    // ...
    Cove\MacroAttributes\ServiceProvider::class,
];
```

If you would like to only load this package's service provider in certain environments, take a look at 
[`sven/env-providers`](https://github.com/svenluijten/env-providers).

### Publishing the configuration file
This package comes with sensible configuration defaults , but you may want to customize them. To do so, publish the
configuration file with `php artisan vendor:publish` and picking `\Cove\AttributeMacros\ServiceProvider` from the list.
This will create a `config/macros.php` file for you to customize.

## Usage
By default, this package looks for macros in the `App\Macros` namespace. Any of the classes tagged with either of the
attributes this package provides in that namespace will automatically be registered.

### Macros
To register a single method or function as a macro, use [`Cove\MacroAttributes\Attributes\Macro`](src/Attributes/Macro.php). 
Unfortunately, due to how PHP doesn't allow re-binding a method to a different class, you'll have to return a callable
from your macro methods like you would with mixins:

```php
<?php

namespace App\Macros;

use Cove\MacroAttributes\Attributes\Macro;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Macros 
{
    #[Macro(target: Collection::class)]
    public function containsThreeItems(): callable
    {
        return function () {
            // ...
        };
    }
    
    #[Macro(target: Request::class)]
    public function hasTwentyHeaders(): callable
    {
        return function () {
            // ...
        };
    }
}
```

### Mixins
To register all methods of a class as macros on the `Response` class, use [the `Cove\MacroAttributes\Attributes\Mixin`
attribute](src/Attributes/Mixin.php):

```php
<?php

namespace App\Macros;

use Cove\MacroAttributes\Attributes\Mixin;
use Illuminate\Http\Response;

#[Mixin(target: Response::class)]
class ResponseMacros
{
    public function headersContain(): callable
    {
        return function (string $needle): bool {
            // ...
        }
    }
}
```

> [!WARNING]
> Keep in mind that all methods on mixin classes must always return a callable!

You may optionally supply the attribute with a `replace` parameter to indicate that pre-applied macros with the same
name should be overridden:

```php
<?php

namespace App\Macros;

use Cove\MacroAttributes\Attributes\Mixin;
use Illuminate\Http\Response;

#[Mixin(target: Response::class, replace: true)]
class ResponseMacros
{
    public function previouslyAppliedMacroMethod(): callable
    {
        return function (): bool {
            // ...
        }
    }
}
```

## Contributing
All contributions (pull requests, issues and feature requests) are welcome. See the [contributors page](../../graphs/contributors) for all
contributors.

## License
`cove/macro-attributes` is licensed under the MIT License (MIT). Please see [the license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/cove/macro-attributes.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-green.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/cove/macro-attributes.svg?style=flat-square
[ico-build]: https://img.shields.io/github/actions/workflow/status/covelabs/macro-attributes/run-tests.yml?style=flat-square

[link-packagist]: https://packagist.org/packages/cove/macro-attributes
[link-downloads]: https://packagist.org/packages/cove/macro-attributes
[link-build]: https://github.com/covelabs/macro-attributes/actions/workflows/run-tests.yml
