# Semaphore PHP
[![Latest Stable Version](https://poser.pugx.org/humans/semaphore-sms/v/stable)](https://packagist.org/packages/humans/semaphore-sms)
[![License](https://poser.pugx.org/humans/semaphore-sms/license)](https://packagist.org/packages/humans/semaphore-sms)

This is a PHP client for the [Semaphore](semaphore.co) SMS service provider with out of the box Laravel integration.

## Installation

Install via composer:

```
composer require humans/semaphore-sms
```

To start using the library, we'll have to provide the Sempahore API key.

## Send a message

```php
$client = new Client(

  '<SEMAPHORE API KEY>',

  // If the sender is left blank, SEMAPHORE will be the default sender name.
  '<SENDER>',

);

$client->message()->send('0917xxxxxxx', '<Your message here>');
```

## Laravel Integration
If you're using Laravel, we have some conveniences set up for you. First off, you can set your
API key and sender name in your .env file.

```
SEMAPHORE_API_KEY=xxxxxxxx
SEMAPHORE_SENDER_NAME=xxxxxxxx
```

**If you have package discovery disabled,** make sure to register the `Humans\Semaphore\Laravel\ServiceProvider` in your `app.php`.

### Send a message
You can use the `Semaphore` facade provided by the package.

```php
use Humans\Semaphore\Laravel\Facades\Semaphore;

Semaphore::message()->send(
    '0917xxxxxxx',
    '<Your message here>'
);

```

### Using Notifications
If you want to use Laravel's Notification features, this package provides a `SemaphoreChannel` and
`SemaphoreMessage` class.

#### Configure your Notifiable
In your notifiable class, add a `routeNotificationForSempahore` method and use the database column that
holds the mobile number.

```php
class User {
    use Notifiable;

    // ...

    public function routeNotificationForSemaphore()
    {
        return $this->mobile_number;
    }
}
```

#### Using Notifications

```php
use Humans\Semaphore\Laravel\Contracts\UsesSemaphore;

class Welcome extends Notification implements UsesSemaphore
{
    public function via($notifiable): array
    {
        return [SemaphoreChannel::class];
    }

    public function toSemaphore($notifiable): SemaphoreMessage
    {
        return (new SemaphoreMessage)
            ->message('<Your message here>');
    }
}

User::first()->notify(new Welcome);
```

#### Using on-demand Notifiables
In the case where you need to send a message but you don't need a model, this package also supports
Laravel's on-demand notifications.

```php
use Humans\Semaphore\Laravel\SemaphoreChannel;use Illuminate\Support\Facades\Notification;

Notification::route(SemaphoreChannel::class, '0917xxxxxxx')->notify(new Welcome);
```
