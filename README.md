# [WIP] Laravel Exchange 1C

[![Latest Version on Packagist](https://img.shields.io/packagist/v/altynbek07/laravel-exchange-1c.svg?style=flat-square)](https://packagist.org/packages/altynbek07/laravel-exchange-1c)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/altynbek07/laravel-exchange-1c/run-tests?label=tests)](https://github.com/altynbek07/laravel-exchange-1c/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/altynbek07/laravel-exchange-1c.svg?style=flat-square)](https://packagist.org/packages/altynbek07/laravel-exchange-1c)

Laravel exchange from 1C.

## Installation

You can install the package via composer:

```bash
composer require altynbek07/laravel-exchange-1c
```

You should set these environment variables in your `.env` file:

```env
EXCHANGE_1C_LOGIN=YourLogin
EXCHANGE_1C_PASSWORD=YourPassword
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Altynbek07\Exchange1C\Exchange1CServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
<?php

use Altynbek07\Exchange1C\Interfaces\GroupInterface;
use Altynbek07\Exchange1C\Interfaces\OfferInterface;
use Altynbek07\Exchange1C\Interfaces\ProductInterface;

return [
    /**
     *
     */
    'exchange_path' => 'exchange-1c',
    /**
     *
     */
    'import_dir' => storage_path('app/exchange-1c'),
    /**
     *
     */
    'login' => env('EXCHANGE_1C_LOGIN', 'admin'),
    /**
     *
     */
    'password' => env('EXCHANGE_1C_PASSWORD', 'admin'),
    /**
     *
     */
    'use_zip' => false,
    /**
     *
     */
    'file_part' => 0,
    /**
     *
     */
    'logging' => true,
    /**
     *
     */
    'importFiles' => ['import.xml', 'offers.xml'],
    /**
     *
     */
    'models' => [
        GroupInterface::class => \App\Models\Category::class,
        ProductInterface::class => \App\Models\Product::class,
        OfferInterface::class => \App\Models\Offer::class,
    ],
];
```

## Usage

TODO

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email altynbek.kazezov.97@gmail.com instead of using the issue tracker.

## Credits

-   [Altynbek](https://github.com/altynbek07)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
