![](https://banners.beyondco.de/Laravel%20Request%20Forwarder.png?theme=light&packageManager=composer+require&packageName=moneo%2Flaravel-request-forwarder&pattern=architect&style=style_1&description=Forward+incoming+requests+to+another+addresses&md=1&showWatermark=0&fontSize=100px&images=server)

# Laravel Request Forwarder

[![Latest Version on Packagist](https://img.shields.io/packagist/v/moneo/laravel-request-forwarder.svg?style=flat-square)](https://packagist.org/packages/moneo/laravel-request-forwarder)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/moneo/laravel-request-forwarder/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/moneo/laravel-request-forwarder/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/moneo/laravel-request-forwarder/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/moneo/laravel-request-forwarder/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/moneo/laravel-request-forwarder.svg?style=flat-square)](https://packagist.org/packages/moneo/laravel-request-forwarder)

Sometimes we need to redirect requests to our application to other addresses. The best example of this is webhooks. Some service providers only send webhooks to a single address.  With this package, you can post the requests coming to your application to another address as it is.

In addition to sending to a single URL, you can also send to different destinations by typing a custom provider. In our package you can see an example that sends notifications to Discord!

## Installation

You can install the package via composer:

```bash
composer require moneo/laravel-request-forwarder
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="request-forwarder-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$requestForwarder = new Moneo\RequestForwarder();
echo $requestForwarder->echoPhrase('Hello, Moneo!');
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

- [Emre Dipi](https://github.com/emredipi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
