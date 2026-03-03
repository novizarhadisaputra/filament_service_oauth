<?php

use App\Filament\App\Resources\Users\Pages\CreateUser;
use App\Filament\App\Resources\Users\Pages\ListUsers;
use App\Models\Permission;
use App\Models\Role;
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
    actingAs($this->user);
    \Filament\Facades\Filament::setTenant($this->system);

    $permissions = [
        'ViewAny:User',
        'View:User',
        'Create:User',
        'Update:User',
        'Delete:User',
    ];

    foreach ($permissions as $permission) {
        Permission::create([
            'name' => $permission,
            'guard_name' => 'web',
        ]);
    }

    $this->user->givePermissionTo($permissions);

});

test('can list users for tenant', function () {
    /** @var \Tests\TestCase $this */
    $otherUser = User::factory()->create(); // UserObserver will auto-attach to $this->system

    Livewire::test(ListUsers::class, ['tenant' => $this->system->id])
        ->assertCanSeeTableRecords([$this->user, $otherUser]);
});

test('cannot see users from other tenant', function () {
    /** @var \Tests\TestCase $this */
    $otherSystem = System::factory()->create();

    $otherUser = null;
    User::withoutEvents(function () use ($otherSystem, &$otherUser) {
        $otherUser = User::factory()->create();
        $otherUser->systems()->attach($otherSystem);
    });

    Livewire::test(ListUsers::class, ['tenant' => $this->system->id])
        ->assertCanNotSeeTableRecords([$otherUser]);
});

test('can create user and assign roles for tenant', function () {
    /** @var \Tests\TestCase $this */
    $role = Role::create([
        'name' => 'Support',
        'guard_name' => 'web',
        'team_id' => $this->system->id,
    ]);

    Livewire::test(CreateUser::class, ['tenant' => $this->system->id])
        ->fillForm([
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'roles' => [$role->id],
        ])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertRedirect();

    $newUser = User::where('email', 'newuser@example.com')->first();
    expect($newUser)->not->toBeNull()
        ->and($newUser->roles)->toHaveCount(1)
        ->and($newUser->roles->first()->id)->toBe($role->id);

    expect($newUser->systems->contains($this->system))->toBeTrue();
});
