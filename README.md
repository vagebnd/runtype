# Laravel Runtype

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vagebond/runtype.svg?style=flat-square)](https://packagist.org/packages/vagebond/runtype)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/vagebnd/runtype/run-tests.yml?branch=main&label=tests)](https://github.com/vagebnd/runtype/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/vagebnd/runtype/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/vagebnd/runtype/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/vagebond/runtype.svg?style=flat-square)](https://packagist.org/packages/vagebond/runtype)

Runtype is a library that you can use to generate types for Laravel Resources, models and other classes.

## Installation

You can install the package via composer:

```bash
composer require vagebond/runtype
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="runtype-config"
```

## Usage

```bash
php artisan runtype:generate
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Gianluca Riggio](https://github.com/mxaGianluca)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
