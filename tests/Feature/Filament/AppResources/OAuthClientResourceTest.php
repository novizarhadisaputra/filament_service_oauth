<?php

use App\Filament\App\Resources\OAuthClients\Pages\CreateOAuthClient;
use App\Filament\App\Resources\OAuthClients\Pages\ListOAuthClients;
use App\Models\OAuthClient;
use App\Models\Permission;
use App\Models\System;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var \Tests\TestCase $this */
    $this->system = System::factory()->create();
    app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($this->system->id);

    $this->user = User::factory()->create();
    $this->user->systems()->attach($this->system);

    \Filament\Facades\Filament::setCurrentPanel(\Filament\Facades\Filament::getPanel('app'));
    $this->withoutMiddleware();

    /** @var \App\Models\User $testUser */
    $testUser = $this->user;
    actingAs($testUser, 'web');

    /** @var \App\Models\System $testSystem */
    $testSystem = $this->system;
    \Filament\Facades\Filament::setTenant($testSystem);

    // Create permissions manually for the test
    $permissions = [
        'ViewAny:OAuthClient',
        'View:OAuthClient',
        'Create:OAuthClient',
        'Update:OAuthClient',
        'Revoke:OAuthClient',
        'RegenerateSecret:OAuthClient',
    ];

    foreach ($permissions as $permission) {
        Permission::create([
            'name' => $permission,
            'guard_name' => 'web',
        ]);
    }

    $this->user->givePermissionTo($permissions);

});

test('can list oauth clients for tenant', function () {
    /** @var \Tests\TestCase $this */
    $clients = OAuthClient::factory()->count(2)->create([
        'owner_id' => $this->system->id,
        'owner_type' => System::class,
        'provider' => 'users',
    ]);

    Livewire::test(ListOAuthClients::class, ['tenant' => $this->system->id])
        ->assertCanSeeTableRecords($clients);
});

test('cannot see oauth clients from other tenant', function () {
    /** @var \Tests\TestCase $this */
    $otherSystem = System::factory()->create();
    $otherClient = OAuthClient::factory()->create([
        'owner_id' => User::factory()->create()->id,
        'owner_type' => User::class,
        'provider' => 'users',
    ]);

    Livewire::test(ListOAuthClients::class, ['tenant' => $this->system->id])
        ->assertCanNotSeeTableRecords([$otherClient]);
});

test('can create oauth client via wizard', function () {
    /** @var \Tests\TestCase $this */
    Livewire::test(CreateOAuthClient::class, ['tenant' => $this->system->id])
        ->fillForm([
            'name' => 'Test Client',
            'redirect_uris' => 'http://localhost/callback',
            'grant_types' => 'password',
        ])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertRedirect();

    $this->assertDatabaseHas(OAuthClient::class, [
        'name' => 'Test Client',
    ]);

    $client = OAuthClient::where('name', 'Test Client')->first();
    expect($client->redirect_uris)->toBe(['http://localhost/callback']);
    expect($client->grant_types)->toBe(['password']);
});

test('can revoke oauth client', function () {
    /** @var \Tests\TestCase $this */
    $client = OAuthClient::factory()->create([
        'owner_id' => $this->system->id,
        'owner_type' => System::class,
        'revoked' => false,
    ]);

    Livewire::test(ListOAuthClients::class, ['tenant' => $this->system->id])
        ->callTableAction('revoke', $client)
        ->assertHasNoTableActionErrors();

    expect($client->fresh()->revoked)->toBeTrue();
});

test('can regenerate oauth client secret', function () {
    /** @var \Tests\TestCase $this */
    $client = OAuthClient::factory()->create([
        'owner_id' => $this->system->id,
        'owner_type' => System::class,
        'client_secret' => 'old-secret',
    ]);

    Livewire::test(ListOAuthClients::class, ['tenant' => $this->system])
        ->callTableAction('regenerateSecret', $client)
        ->assertHasNoTableActionErrors();

    expect($client->fresh()->client_secret)->not->toBe('old-secret');
});
