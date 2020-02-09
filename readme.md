# Semaphore PHP
[![Latest Stable Version](https://poser.pugx.org/humans/semaphore-sms/v/stable)](https://packagist.org/packages/humans/semaphore-sms)
[![License](https://poser.pugx.org/humans/semaphore-sms/license)](https://packagist.org/packages/humans/semaphore-sms)

This is a PHP client for the [Semaphore](semaphore.co) SMS service provider with out of the box Laravel integration.

[Read the complete documentation here.](https://humans.github.io/semaphore-php)

::: tip
_This library requires a minimum PHP version of 7.1_
:::

## Installation

Install via composer:

```
composer require humans/semaphore-sms
```

To start using the library, we'll have to provide the Sempahore API key.

## Usage

### Sending a Message

```php
$client = new Client('SEMAPHORE API KEY', 'Sender Name');
$client->message()->send('0917xxxxxxx', 'Your message here');
```