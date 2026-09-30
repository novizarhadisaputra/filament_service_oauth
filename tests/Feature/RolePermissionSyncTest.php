<?php

use App\Models\OAuthClient;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

test('syncPermissions updates updated_at timestamp and triggers cache invalidation webhook', function () {
    // 1. Setup client to receive webhook
    $client = new OAuthClient([
        'name' => 'Backend Service',
        'redirect_uris' => ['http://127.0.0.1:8000/callback'],
        'grant_types' => ['authorization_code'],
    ]);
    $client->save();

    Http::fake([
        'http://127.0.0.1:8000/api/v1/webhook/permissions/clear-cache' => Http::response(['message' => 'Cache cleared'], 200),
    ]);

    // 2. Create role and permissions
    $role = Role::create([
        'name' => 'Doctor',
        'guard_name' => 'web',
    ]);

    $perm1 = Permission::create(['name' => 'View:MedicalRecord', 'guard_name' => 'web']);
    $perm2 = Permission::create(['name' => 'Edit:MedicalRecord', 'guard_name' => 'web']);

    // Set updated_at to the past
    $pastTime = now()->subHour();
    $role->updated_at = $pastTime;
    $role->saveQuietly();

    expect($role->fresh()->updated_at->timestamp)->toBe($pastTime->timestamp);

    // 3. Sync permissions
    $role->syncPermissions(['View:MedicalRecord', 'Edit:MedicalRecord']);

    // 4. Assert updated_at was touched
    $refreshedRole = $role->fresh();
    expect($refreshedRole->updated_at->timestamp)->toBeGreaterThan($pastTime->timestamp)
        ->and($refreshedRole->hasPermissionTo('View:MedicalRecord'))->toBeTrue()
        ->and($refreshedRole->hasPermissionTo('Edit:MedicalRecord'))->toBeTrue();

    // 5. Assert webhook was sent to backend
    Http::assertSent(function ($request) use ($client) {
        return $request->url() === 'http://127.0.0.1:8000/api/v1/webhook/permissions/clear-cache'
            && $request->header('X-Client-Id')[0] === $client->client_id;
    });
});

test('syncPermissions works without infinite loop when revoking permissions', function () {
    $role = Role::create([
        'name' => 'Nurse',
        'guard_name' => 'web',
    ]);

    $perm = Permission::create(['name' => 'View:Vitals', 'guard_name' => 'web']);
    $role->syncPermissions(['View:Vitals']);
    expect($role->fresh()->hasPermissionTo('View:Vitals'))->toBeTrue();

    // Revoke all by syncing empty array
    $role->syncPermissions([]);
    expect($role->fresh()->permissions)->toBeEmpty();
});
