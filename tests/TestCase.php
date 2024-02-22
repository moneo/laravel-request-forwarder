<?php

namespace Moneo\RequestForwarder\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Moneo\RequestForwarder\RequestForwarderServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Moneo\\RequestForwarder\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
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

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-request-forwarder_table.php.stub';
        $migration->up();
        */
    }
}
