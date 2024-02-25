<?php

namespace Moneo\RequestForwarder\Tests;

use Illuminate\Support\Facades\Route;
use Moneo\RequestForwarder\RequestForwarderServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerTestRoutes();
    }

    protected function getPackageProviders($app)
    {
        return [
            RequestForwarderServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('app.debug', true);
    }

    protected function registerTestRoutes(): void
    {
        Route::middleware('api')->group(function () {
            Route::any('/', fn () => 'No Middleware')
                ->name('no-middleware');

            Route::middleware('request-forwarder')
                ->any('/middleware', fn () => 'With Middleware')
                ->name('middleware');

            Route::middleware('request-forwarder:wrong-webhook-name')
                ->any('/wrong-webhook-group-name-use-of-middleware', fn () => 'With Middleware, But Wrong Webhook Group Name');
        });
    }
}
