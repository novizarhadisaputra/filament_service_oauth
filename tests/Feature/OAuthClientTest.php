<?php

use App\Models\OAuthClient;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('oauth client generates prefixed client_id and client_secret', function () {
    $client = new OAuthClient([
        'name' => 'Test Client',
        'redirect_uris' => ['http://localhost'],
        'grant_types' => ['password'],
    ]);

    $client->save();

    expect($client->client_id)->toStartWith('client_')
        ->and($client->client_secret)->toStartWith('secret_')
        ->and(strlen($client->client_id))->toBe(39) // 'client_' (7) + 32 = 39
        ->and(strlen($client->client_secret))->toBe(39); // 'secret_' (7) + 32 = 39
});
