# Laravel Semaphore

[Semaphore](semaphore.co) is a Philippine SMS Service provider.

## Installation

```
composer require artisan/laravel-semaphore
```

If you're using Laravel 5.5's package discovery, then there's no need to add the service provider.

Otherwise, add the Semaphore service provider in your `config/app.php`

```php
return [
    'providers' => [
        // ...

        Artisan\Semaphore\SemaphoreServiceProvider::class,
    ],
]
```

## Configuration

In your `.env` file, copy this default template and you can then add your Semaphore API key and sender name.

```
SEMAPHORE_KEY=
SEMAPHORE_FROM_NAME=
```

If you want to customize the config file, publish the config file via:

```bash
php artisan vendor:publish --tags=semaphore
```

## Usage

After creating a notification, we can start using the `Aritsan\Semaphore\SemaphoreChannel` to send out your SMS.

You also have to create a `toSemaphore()` method to build your

```php
use Artisan\Semaphore\SemaphoreChannel;

class ReminderMessage extends notification
{
    public function via($notifiable)
    {
        return ['slack', SemaphoreChannel::class];
    }

    public function toSemaphore($notifiable)
    {
        return "Hey {$notifiable->name}, don't forget to brush your teeth!";
    }
}
```
