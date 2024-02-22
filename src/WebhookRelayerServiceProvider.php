<?php

namespace Moneo\WebhookRelayer;

use Illuminate\Http\Client\Factory;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WebhookRelayerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-request-forwarder')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        $this->app->bind('laravel_webhook_relayer.client', function ($app): Factory {
            return $app[Factory::class];
        });

        $this->app->singleton(WebhookRelayer::class, function ($app): WebhookRelayer {
            return new WebhookRelayer(
                $app->make('laravel_webhook_relayer.client'),
                config('webhook-relayer.webhooks'),
            );
        });
    }
}
