<?php

use App\Models\OAuthClient;
use App\Models\Role;
use App\Models\System;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->system = System::create([
        'name' => 'SIMRS',
        'slug' => 'simrs',
        'description' => 'SIMRS System',
    ]);

    $rawSecret = 'secret123';
    $this->client = OAuthClient::create([
        'name' => 'SIMRS Client',
        'client_id' => 'simrs-client-id',
        'client_secret' => Hash::make($rawSecret),
        'redirect_uris' => ['http://localhost:8000/callback'],
        'grant_types' => ['client_credentials'],
        'system_id' => $this->system->id,
    ]);
    $this->rawSecret = $rawSecret;
});

test('sync user with explicit roles assigns the requested roles', function () {
    $response = $this->withHeaders([
        'X-Client-Id' => $this->client->client_id,
        'X-Client-Secret' => $this->rawSecret,
    ])->postJson('/api/integrations/users', [
        'name' => 'Dr. Maria Sp.A',
        'username' => 'dr.maria',
        'email' => 'dr.maria@example.com',
        'system_slug' => 'simrs',
        'roles' => ['Doctor', 'Specialist'],
    ]);

    $response->assertOk()
        ->assertJsonPath('data.username', 'dr.maria');

    $user = User::where('username', 'dr.maria')->first();
    expect($user)->not->toBeNull();

    setPermissionsTeamId($this->system->id);
    expect($user->hasRole('Doctor'))->toBeTrue()
        ->and($user->hasRole('Specialist'))->toBeTrue();
});

test('sync user without roles defaults to User role instead of guessing from name or username', function () {
    $response = $this->withHeaders([
        'X-Client-Id' => $this->client->client_id,
        'X-Client-Secret' => $this->rawSecret,
    ])->postJson('/api/integrations/users', [
        'name' => 'dr. Maria Specialist',
        'username' => 'dr.Maria',
        'email' => 'dr.maria@example.com',
        'system_slug' => 'simrs',
        'metadata' => [
            'paramedic_id' => '123',
            'person_id' => '456',
        ],
    ]);

    $response->assertOk()
        ->assertJsonPath('data.username', 'dr.Maria');

    $user = User::where('username', 'dr.Maria')->first();
    expect($user)->not->toBeNull();

    setPermissionsTeamId($this->system->id);
    // Should NOT guess Doctor or MedicalCoder
    expect($user->hasRole('Doctor'))->toBeFalse()
        ->and($user->hasRole('MedicalCoder'))->toBeFalse()
        ->and($user->hasRole('User'))->toBeTrue();
});

test('sync user without roles preserves existing roles if already assigned', function () {
    $user = User::create([
        'name' => 'Existing Doctor',
        'username' => 'dr.existing',
        'email' => 'existing@example.com',
        'password' => Hash::make('password'),
    ]);
    $user->systems()->attach($this->system->id);

    setPermissionsTeamId($this->system->id);
    $doctorRole = Role::firstOrCreate([
        'name' => 'Doctor',
        'guard_name' => 'web',
        'team_id' => $this->system->id,
    ]);
    $user->assignRole($doctorRole);

    $response = $this->withHeaders([
        'X-Client-Id' => $this->client->client_id,
        'X-Client-Secret' => $this->rawSecret,
    ])->postJson('/api/integrations/users', [
        'name' => 'Existing Doctor Updated Name',
        'username' => 'dr.existing',
        'email' => 'existing@example.com',
        'system_slug' => 'simrs',
    ]);

    $response->assertOk();

    $user->refresh();
    setPermissionsTeamId($this->system->id);
    expect($user->hasRole('Doctor'))->toBeTrue()
        ->and($user->name)->toBe('Existing Doctor Updated Name');
});
