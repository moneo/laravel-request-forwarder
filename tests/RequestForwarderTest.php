<?php

use Illuminate\Support\Facades\Http;

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
