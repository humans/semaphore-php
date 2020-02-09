<?php

namespace Humans\Semaphore\Laravel;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Humans\Semaphore\Client;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/config/semaphore.php';

        $this->mergeConfigFrom($configPath, 'semaphore');

        $this->app->bind(Client::class, function () {
            return new Client(
                Config::get('semaphore.api_key'),
                Config::get('semaphore.sender_name')
            );
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/config/semaphore.php';

        $this->publishes([$configPath => App::configPath('semaphore.php')], 'config');
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     * @return void
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => App::configPath('semaphore.php')], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [SemaphoreChannel::class];
    }
}
