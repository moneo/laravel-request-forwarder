<?php

use Illuminate\Support\Facades\Http;
use Moneo\RequestForwarder\RequestForwarder;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('must not call any http request', function () {
    Http::fake();
    get('/')->assertStatus(200);
    post('/')->assertStatus(200);
    Http::assertNothingSent();
});

it('must send hooks', function () {
    Http::fake();
    get('/middleware')->assertStatus(200);
    Http::assertSentCount(2);
    get('/middleware')->assertStatus(200);
    Http::assertSentCount(4);
});

it('must have valid default webhook group name in config file', function () {
    $config = config('request-forwarder');
    expect($config['default_webhook_group_name'])->toBe('default');
});

it('validates config file configuration is right', function () {
    $config = config('request-forwarder');
    expect($config['webhooks'])->toBeArray();
    foreach (array_keys($config['webhooks']) as $webhookGroupName) {
        expect($webhookGroupName)->toBeString();
        expect($config['webhooks'][$webhookGroupName])->toBeArray();
        expect($config['webhooks'][$webhookGroupName]['targets'])->toBeArray();
        foreach ($config['webhooks'][$webhookGroupName]['targets'] as $target) {
            expect($target['url'])->toBeString();
            expect($target['method'])->toBeString();
            if (array_key_exists('provider', $target)) {
                $provider = $target['provider'];
                expect($provider)->toBeString();

                $providerClass = new \ReflectionClass($provider);
                expect($providerClass->implementsInterface(\Moneo\RequestForwarder\Providers\ProviderInterface::class))->toBeTrue();
            }
        }
    }
});

it('test private getWebhookInfo method returns valid data in RequestForwarder.php', function () {
    $requestForwarder = app()->make(RequestForwarder::class);
    $method = new ReflectionMethod(RequestForwarder::class, 'getWebhookInfo');
    $method->setAccessible('public');
    $getWebhookInfoNullParameterReturnedData = $method->invoke($requestForwarder);

    expect($getWebhookInfoNullParameterReturnedData)->toBeArray();

    $getWebhookInfoEmptyStringParameterReturnedData = $method->invoke($requestForwarder, '');

    expect($getWebhookInfoEmptyStringParameterReturnedData)->toBeArray();
});

it('test getWebhookTargets method returns valid data in RequestForwarder.php', function () {
    $requestForwarder = app()->make(RequestForwarder::class);
    $method = new ReflectionMethod(RequestForwarder::class, 'getWebhookTargets');
    $method->setAccessible('public');
    $getWebhookTargetsReturnedData = $method->invoke($requestForwarder);

    expect($getWebhookTargetsReturnedData)->toBeArray();
});

it('must throw WebhookGroupNameNotFoundException when use wrong webhook group name on defined route', function () {
    Http::fake();
    $testResponse = get('/wrong-webhook-group-name-use-of-middleware', ['Accept' => 'application/json']);

    $testResponse->assertStatus(500);

    $testResponseData = $testResponse->json();

    expect($testResponseData['exception'])->toBe(Moneo\RequestForwarder\Exceptions\WebhookGroupNameNotFoundException::class);
});
