<?php

namespace BlockadeLabs\SDK\Providers;

use BlockadeLabs\SDK\SDKClient;
use Illuminate\Support\ServiceProvider;

class SDKServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../../config/blockadelabs.php', 'blockadelabs');

        // Register the main class to use with the facade
        $this->app->singleton('blockadelabs.sdk.client', function () {
            return new SDKClient();
        });
    }
}
