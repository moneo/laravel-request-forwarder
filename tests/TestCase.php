<?php

namespace Moneo\RequestForwarder\Tests;

use Illuminate\Support\Facades\Route;
use Moneo\RequestForwarder\RequestForwarderMiddleware;
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
    }

    protected function registerTestRoutes(): void
    {
        Route::middleware('api')->group(function () {
            Route::any('/', fn () => 'No Middleware')
                ->name('no-middleware');

            Route::middleware(RequestForwarderMiddleware::class)
                ->any('/middleware', fn () => 'With Middleware')
                ->name('middleware');
        });
    }
}
