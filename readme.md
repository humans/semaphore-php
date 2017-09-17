# Laravel Semaphore

[Semaphore](semaphore.co) is a Philippine SMS Service provider.


## Configuration

In your `.env` file, copy this default template and you can then add your Semaphore API key and sender name.

```
SEMAPHORE_KEY=
SEMAPHORE_FROM_NAME=
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
