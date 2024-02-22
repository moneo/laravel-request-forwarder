<?php

namespace Moneo\RequestForwarder;

use Illuminate\Http\Client\Factory;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RequestForwarderServiceProvider extends PackageServiceProvider
{
    /**
     * @param Package $package
     * @return void
     */
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

    /**
     * @return void
     */
    public function registeringPackage(): void
    {
        $this->app->bind('laravel_request_forwarder.client', function ($app): Factory {
            return $app[Factory::class];
        });

        $this->app->singleton(RequestForwarder::class, function ($app): RequestForwarder {
            return new RequestForwarder(
                $app->make('laravel_request_forwarder.client'),
                config('request-forwarder.webhooks'),
            );
        });
    }
}
