<?php

use App\Models\OAuthClient;

test('oauth client generates prefixed client_id and client_secret', function () {
    $client = new OAuthClient([
        'name' => 'Test Client',
        'redirect_uris' => ['http://localhost'],
        'grant_types' => ['password'],
    ]);

    $client->save();

    expect($client->client_id)->toStartWith('client_')
        ->and($client->plainSecret)->toStartWith('client_secret_')
        ->and(strlen($client->client_id))->toBe(39) // 'client_' (7) + 32 = 39
        ->and(strlen($client->plainSecret))->toBe(46) // 'client_secret_' (14) + 32 = 46
        ->and(\Illuminate\Support\Facades\Hash::check($client->plainSecret, $client->client_secret))->toBeTrue()
        ->and(\Illuminate\Support\Facades\Crypt::decryptString($client->encrypted_secret))->toBe($client->plainSecret);
});
