<?php

use App\Models\Role;
use App\Models\System;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

test('users are created with uuid', function () {
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    expect($user->id)->toBeString();
    expect(Str::isUuid($user->id))->toBeTrue();
});

test('roles are created with uuid', function () {
    $system = System::create(['name' => 'Test System', 'slug' => 'test-system']);
    setPermissionsTeamId($system->id);

    $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);

    expect($role->id)->toBeString();
    expect(Str::isUuid($role->id))->toBeTrue();
    expect($role->team_id)->toBe($system->id);

    setPermissionsTeamId(null);
});

test('user can have different roles in different systems', function () {
    $simrs = System::create(['name' => 'SIMRS', 'slug' => 'simrs']);
    $absensi = System::create(['name' => 'Absensi', 'slug' => 'absensi']);

    $user = User::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => bcrypt('password'),
    ]);

    // Role in SIMRS
    setPermissionsTeamId($simrs->id);
    $simrsAdmin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $user->assignRole($simrsAdmin);

    expect($user->hasRole('admin'))->toBeTrue();

    // Role in Absensi
    setPermissionsTeamId($absensi->id);
    app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    $user->unsetRelation('roles')->unsetRelation('permissions');

    $absensiUser = Role::create(['name' => 'user', 'guard_name' => 'web', 'team_id' => $absensi->id]);
    $user->assignRole($absensiUser);

    expect($user->hasRole('user'))->toBeTrue();
    expect($user->hasRole('admin'))->toBeFalse(); // Should be false in Absensi context

    // Check back in SIMRS
    setPermissionsTeamId($simrs->id);
    app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    $user->unsetRelation('roles')->unsetRelation('permissions');

    expect($user->hasRole('admin'))->toBeTrue();
    expect($user->hasRole('user'))->toBeFalse();

    setPermissionsTeamId(null);
});
