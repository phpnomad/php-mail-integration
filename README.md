# phpnomad/php-mail-integration

[![Latest Version](https://img.shields.io/packagist/v/phpnomad/php-mail-integration.svg)](https://packagist.org/packages/phpnomad/php-mail-integration)
[![Total Downloads](https://img.shields.io/packagist/dt/phpnomad/php-mail-integration.svg)](https://packagist.org/packages/phpnomad/php-mail-integration)
[![PHP Version](https://img.shields.io/packagist/php-v/phpnomad/php-mail-integration.svg)](https://packagist.org/packages/phpnomad/php-mail-integration)
[![License](https://img.shields.io/packagist/l/phpnomad/php-mail-integration.svg)](https://packagist.org/packages/phpnomad/php-mail-integration)

Integrates PHP's built-in `mail()` function with `phpnomad/email`'s `EmailStrategy`. Reach for this when the host already has a working mail transport configured at the PHP level and your application just needs something to drop into the `EmailStrategy` slot. There are no external library dependencies, no queuing, and no template rendering. The package is a thin adapter between the `EmailStrategy` contract and the `mail()` call.

## Installation

```bash
composer require phpnomad/php-mail-integration
```

## What This Provides

- `PHPMailStrategy` implements `PHPNomad\Email\Interfaces\EmailStrategy`. It joins recipients into a comma-separated list, flattens headers into `Key: Value` lines, and hands the message to PHP's `mail()`. A `false` return from `mail()` raises `EmailSendFailedException`.

## Requirements

- `phpnomad/email ^1.0`
- A working PHP `mail()` configuration on the host (sendmail binary, SMTP relay, or the equivalent). The `mail()` function returns `false` when the transport is missing or misconfigured, and this strategy converts that into an `EmailSendFailedException`.

## Usage

Bind `PHPMailStrategy` to `EmailStrategy` inside an initializer so the container hands it to anything that depends on email sending.

```php
<?php

namespace MyApp\Initializers;

use PHPNomad\Email\Interfaces\EmailStrategy;
use PHPNomad\Loader\Interfaces\HasClassDefinitions;
use PHPNomad\Mail\Integration\Strategies\PHPMailStrategy;

class EmailInitializer implements HasClassDefinitions
{
    public function getClassDefinitions(): array
    {
        return [
            PHPMailStrategy::class => EmailStrategy::class,
        ];
    }
}
```

Register the initializer in your bootstrapper and any service that type-hints `EmailStrategy` will receive a `PHPMailStrategy` instance.

## Documentation

PHPNomad bootstrapping and initializers are documented at [phpnomad.com](https://phpnomad.com). The underlying function is documented in the PHP manual at [php.net/manual/en/function.mail.php](https://www.php.net/manual/en/function.mail.php).

## License

MIT. See [LICENSE.txt](LICENSE.txt).
