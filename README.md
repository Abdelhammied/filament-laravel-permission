# Filament Laravel Permission

[![Latest Version on Packagist](https://img.shields.io/packagist/v/abdelhammied/filament-laravel-permission.svg?style=flat-square)](https://packagist.org/packages/abdelhammied/filament-laravel-permission)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/abdelhammied/filament-laravel-permission/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/abdelhammied/filament-laravel-permission/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/abdelhammied/filament-laravel-permission/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/abdelhammied/filament-laravel-permission/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/abdelhammied/filament-laravel-permission.svg?style=flat-square)](https://packagist.org/packages/abdelhammied/filament-laravel-permission)



A Laravel Filament package to manage user permissions and roles in filament with spatie/laravel-permission


## Installation

You can install the package via composer:

```bash
composer require abdelhammied/filament-laravel-permission
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-laravel-permission-config"
```

This is the contents of the published config file:

```php
return [
    'styling' => [
        'show_form_permissions_header_actions' => true,
        'permissions_columns' => 3,
        'permissions_collapsible' => false,
        'permissions_collapsed' => false,
    ],

    'guards' => [
        'use_single_default_guard' => false,
        'default_guard' => 'nova',

        'options' => [
            'web' => 'Web',
            'api' => 'API',
            'nova' => 'Nova',
        ],
    ],
];
```

## Usage

```php
$filamentLaravelPermission = new Abdelhammied\FilamentLaravelPermission();
echo $filamentLaravelPermission->echoPhrase('Hello, Abdelhammied!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Abdelhammied Elsayed](https://github.com/Abdelhammied)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
