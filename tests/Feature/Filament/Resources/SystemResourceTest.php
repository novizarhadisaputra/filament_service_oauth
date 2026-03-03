<?php

use App\Filament\Resources\Systems\Pages\CreateSystem;
use App\Filament\Resources\Systems\Pages\ListSystems;
use App\Models\Role;
use App\Models\System;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->system = System::factory()->create();
    app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($this->system->id);

    // Create permissions manually for the test
    $permissions = [
        'ViewAny:System',
        'View:System',
        'Create:System',
        'Update:System',
        'Activate:System',
        'Deactivate:System',
    ];

    foreach ($permissions as $permission) {
        \App\Models\Permission::firstOrCreate([
            'name' => $permission,
            'guard_name' => 'web',
        ]);
    }

    $role = Role::firstOrCreate([
        'name' => 'super_admin',
        'guard_name' => 'web',
        'team_id' => $this->system->id,
    ]);
    $role->syncPermissions($permissions);

    $this->user = User::factory()->create();
    $this->user->assignRole($role);
    $this->system->users()->attach($this->user);

    \Filament\Facades\Filament::setCurrentPanel(\Filament\Facades\Filament::getPanel('admin'));
    $this->withoutMiddleware();
    actingAs($this->user, 'web');
});

test('can list systems', function () {
    $systems = System::factory()->count(3)->create();

    Livewire::test(ListSystems::class)
        ->assertCanSeeTableRecords($systems);
});

test('can create system via wizard', function () {
    Livewire::test(CreateSystem::class)
        ->fillForm([
            'name' => 'Test System',
            'slug' => 'test-system',
            'description' => 'System description',
        ])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertRedirect();

    $this->assertDatabaseHas(System::class, [
        'name' => 'Test System',
        'slug' => 'test-system',
    ]);
});

test('can activate system', function () {
    $system = System::factory()->create(['is_active' => false]);

    $test = Livewire::test(ListSystems::class);
    // dump($test->instance());

    $test->callTableAction('activate', $system)
        ->assertHasNoTableActionErrors();

    expect($system->fresh()->is_active)->toBeTrue();
});

test('can deactivate system', function () {
    $system = System::factory()->create(['is_active' => true]);

    Livewire::test(ListSystems::class)
        ->callTableAction('deactivate', $system)
        ->assertHasNoTableActionErrors();

    expect($system->fresh()->is_active)->toBeFalse();
});
