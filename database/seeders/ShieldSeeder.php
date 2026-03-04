<?php

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $tenants = '[{"id":"019cb7e2-040b-71fd-aecc-8cf5ba16b891","name":"SIMRS","slug":"simrs","system_code":"SYS-NP3FBQXQ","description":null,"is_active":true,"created_at":"2026-03-04T08:06:08.000000Z","updated_at":"2026-03-04T08:06:08.000000Z"},{"id":"019cb7e2-0508-73a1-84b6-a4f1e0118970","name":"E-Kinerja","slug":"e-kinerja","system_code":"SYS-L21D7KPE","description":null,"is_active":true,"created_at":"2026-03-04T08:06:08.000000Z","updated_at":"2026-03-04T08:06:08.000000Z"},{"id":"019cb7e2-0601-72bc-b53a-67fcdd8e3782","name":"Absensi Online","slug":"absensi","system_code":"SYS-CU1SCYC5","description":null,"is_active":true,"created_at":"2026-03-04T08:06:09.000000Z","updated_at":"2026-03-04T08:06:09.000000Z"}]';
        $users = '[{"id":"019cb7e2-02ee-7163-a70d-657bab8ac83b","name":"Test User","email":"test@example.com","email_verified_at":"2026-03-04T08:06:08.000000Z","created_at":"2026-03-04T08:06:08.000000Z","updated_at":"2026-03-04T08:06:08.000000Z","username":null,"password":"$2y$12$9VwN41imbu\\/iHdp6MwPPCu7\\/RjLPMjYicVSF9FnwHBluUV0RxRg\\/C","tenant_roles":[],"tenant_permissions":[]},{"id":"019cb7e2-03f7-7065-a656-c4a736e446b1","name":"Global Super Admin","email":"super-admin@health.id","email_verified_at":null,"created_at":"2026-03-04T08:06:08.000000Z","updated_at":"2026-03-04T08:06:08.000000Z","username":null,"password":"$2y$12$d55YMLsGZXzFXWCbElDgt.2diPk4d3chD5KiS31AswzixqzZqW15O","tenant_roles":{"_global":["super_admin"]},"tenant_permissions":[]},{"id":"019cb7e2-04f7-708c-a7d8-cac9b8a6674e","name":"Admin SIMRS","email":"admin-simrs@health.id","email_verified_at":null,"created_at":"2026-03-04T08:06:08.000000Z","updated_at":"2026-03-04T08:06:08.000000Z","username":null,"password":"$2y$12$TUCXyoN4kQlkRHTk5XNCteE5xUAMf0k4Bzyhweq5d\\/pBAX.W9FXny","tenant_roles":{"019cb7e2-040b-71fd-aecc-8cf5ba16b891":["admin"]},"tenant_permissions":[]},{"id":"019cb7e2-05f2-7388-a4bc-683168bfa7b4","name":"Admin E-Kinerja","email":"admin-e-kinerja@health.id","email_verified_at":null,"created_at":"2026-03-04T08:06:09.000000Z","updated_at":"2026-03-04T08:06:09.000000Z","username":null,"password":"$2y$12$eci2V072sigYVsFZ0yyNwuKjbXUhL8KB.tXqalYfbpIG7zOEOlscS","tenant_roles":{"019cb7e2-0508-73a1-84b6-a4f1e0118970":["admin"]},"tenant_permissions":[]},{"id":"019cb7e2-06ec-703c-809c-c377d71406ce","name":"Admin Absensi Online","email":"admin-absensi@health.id","email_verified_at":null,"created_at":"2026-03-04T08:06:09.000000Z","updated_at":"2026-03-04T08:06:09.000000Z","username":null,"password":"$2y$12$5Fzd6XVRcRgce59l64SBYuD1y8E5d5ZrZ.QMqb5rUQ4zYgdfnbg2S","tenant_roles":{"019cb7e2-0601-72bc-b53a-67fcdd8e3782":["admin"]},"tenant_permissions":[]}]';
        $userTenantPivot = '[]';
        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["ViewAny:OAuthClient","View:OAuthClient","Create:OAuthClient","Update:OAuthClient","Delete:OAuthClient","Restore:OAuthClient","ForceDelete:OAuthClient","ForceDeleteAny:OAuthClient","RestoreAny:OAuthClient","Replicate:OAuthClient","Reorder:OAuthClient","Activate:OAuthClient","Deactivate:OAuthClient","RegenerateSecret:OAuthClient","Revoke:OAuthClient","ViewAny:User","View:User","Create:User","Update:User","Delete:User","Restore:User","ForceDelete:User","ForceDeleteAny:User","RestoreAny:User","Replicate:User","Reorder:User","Activate:User","Deactivate:User","RegenerateSecret:User","Revoke:User","ViewAny:System","View:System","Create:System","Update:System","Delete:System","Restore:System","ForceDelete:System","ForceDeleteAny:System","RestoreAny:System","Replicate:System","Reorder:System","Activate:System","Deactivate:System","RegenerateSecret:System","Revoke:System","ViewAny:Role","View:Role","Create:Role","Update:Role","Delete:Role","Restore:Role","ForceDelete:Role","ForceDeleteAny:Role","RestoreAny:Role","Replicate:Role","Reorder:Role","Activate:Role","Deactivate:Role","RegenerateSecret:Role","Revoke:Role"],"team_id":null},{"name":"admin","guard_name":"web","permissions":[],"team_id":"019cb7e2-040b-71fd-aecc-8cf5ba16b891"},{"name":"operator","guard_name":"web","permissions":[],"team_id":"019cb7e2-040b-71fd-aecc-8cf5ba16b891"},{"name":"user","guard_name":"web","permissions":[],"team_id":"019cb7e2-040b-71fd-aecc-8cf5ba16b891"},{"name":"admin","guard_name":"web","permissions":[],"team_id":"019cb7e2-0508-73a1-84b6-a4f1e0118970"},{"name":"operator","guard_name":"web","permissions":[],"team_id":"019cb7e2-0508-73a1-84b6-a4f1e0118970"},{"name":"user","guard_name":"web","permissions":[],"team_id":"019cb7e2-0508-73a1-84b6-a4f1e0118970"},{"name":"admin","guard_name":"web","permissions":[],"team_id":"019cb7e2-0601-72bc-b53a-67fcdd8e3782"},{"name":"operator","guard_name":"web","permissions":[],"team_id":"019cb7e2-0601-72bc-b53a-67fcdd8e3782"},{"name":"user","guard_name":"web","permissions":[],"team_id":"019cb7e2-0601-72bc-b53a-67fcdd8e3782"}]';
        $directPermissions = '[]';

        // 1. Seed tenants first (if present)
        if (! blank($tenants) && $tenants !== '[]') {
            static::seedTenants($tenants);
        }

        // 2. Seed roles with permissions
        static::makeRolesWithPermissions($rolesWithPermissions);

        // 3. Seed direct permissions
        static::makeDirectPermissions($directPermissions);

        // 4. Seed users with their roles/permissions (if present)
        if (! blank($users) && $users !== '[]') {
            static::seedUsers($users);
        }

        // 5. Seed user-tenant pivot (if present)
        if (! blank($userTenantPivot) && $userTenantPivot !== '[]') {
            static::seedUserTenantPivot($userTenantPivot);
        }

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function seedTenants(string $tenants): void
    {
        if (blank($tenantData = json_decode($tenants, true))) {
            return;
        }

        $tenantModel = 'App\Models\System';
        if (blank($tenantModel)) {
            return;
        }

        foreach ($tenantData as $tenant) {
            $tenantModel::firstOrCreate(
                ['id' => $tenant['id']],
                $tenant
            );
        }
    }

    protected static function seedUsers(string $users): void
    {
        if (blank($userData = json_decode($users, true))) {
            return;
        }

        $userModel = 'App\Models\User';
        $tenancyEnabled = true;

        foreach ($userData as $data) {
            // Extract role/permission data before creating user
            $roles = $data['roles'] ?? [];
            $permissions = $data['permissions'] ?? [];
            $tenantRoles = $data['tenant_roles'] ?? [];
            $tenantPermissions = $data['tenant_permissions'] ?? [];
            unset($data['roles'], $data['permissions'], $data['tenant_roles'], $data['tenant_permissions']);

            $user = $userModel::firstOrCreate(
                ['email' => $data['email']],
                $data
            );

            // Handle tenancy mode - sync roles/permissions per tenant
            if ($tenancyEnabled && (! empty($tenantRoles) || ! empty($tenantPermissions))) {
                foreach ($tenantRoles as $tenantId => $roleNames) {
                    $contextId = $tenantId === '_global' ? null : $tenantId;
                    setPermissionsTeamId($contextId);
                    $user->syncRoles($roleNames);
                }

                foreach ($tenantPermissions as $tenantId => $permissionNames) {
                    $contextId = $tenantId === '_global' ? null : $tenantId;
                    setPermissionsTeamId($contextId);
                    $user->syncPermissions($permissionNames);
                }
            } else {
                // Non-tenancy mode
                if (! empty($roles)) {
                    $user->syncRoles($roles);
                }

                if (! empty($permissions)) {
                    $user->syncPermissions($permissions);
                }
            }
        }
    }

    protected static function seedUserTenantPivot(string $pivot): void
    {
        if (blank($pivotData = json_decode($pivot, true))) {
            return;
        }

        $pivotTable = 'system_user';
        if (blank($pivotTable)) {
            return;
        }

        foreach ($pivotData as $row) {
            $uniqueKeys = [];

            if (isset($row['user_id'])) {
                $uniqueKeys['user_id'] = $row['user_id'];
            }

            $tenantForeignKey = 'team_id';
            if (! blank($tenantForeignKey) && isset($row[$tenantForeignKey])) {
                $uniqueKeys[$tenantForeignKey] = $row[$tenantForeignKey];
            }

            if (! empty($uniqueKeys)) {
                DB::table($pivotTable)->updateOrInsert($uniqueKeys, $row);
            }
        }
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            return;
        }

        /**
         * ## Shield Seeder & Super Admin Fixes
         *
         * I have optimized the seeding process and fixed the `super_admin` role assignment.
         *
         * ### Changes Made
         * - **Updated `ShieldSeeder.php`**: Now correctly assigns all 60 permissions to the global `super_admin` role (team_id: null).
         * - **Configured `filament-shield.php`**: Enabled `define_via_gate => true`. This is the most robust way to ensure super admins have access to everything, bypasses authorization checks.
         * - **Cleaned up `DatabaseSeeder.php`**: Removed redundant `AdminSeeder::class` as its functionality is now completely integrated into `ShieldSeeder.php`.
         *
         * ### Verification Results
         * After running `php artisan migrate:fresh --seed`, I verified the state via Tinker:
         * - **User Role**: `super-admin@health.id` has the `super_admin` role.
         * - **Permissions count**: The user has full access (60 permissions).
         * - **Global Role**: The `super_admin` role (where `team_id` is null) has 60 permissions attached.
         *
         * ```text
         * Roles: ["super_admin"]
         * Permissions count: 60
         * Global Role Permissions: 60
         * ```
         */

        /** @var \Illuminate\Database\Eloquent\Model $roleModel */
        $roleModel = Utils::getRoleModel();
        /** @var \Illuminate\Database\Eloquent\Model $permissionModel */
        $permissionModel = Utils::getPermissionModel();

        $tenancyEnabled = true;
        $teamForeignKey = 'team_id';

        foreach ($rolePlusPermissions as $rolePlusPermission) {
            $tenantId = $rolePlusPermission[$teamForeignKey] ?? null;

            // Set tenant context for role creation and permission sync
            if ($tenancyEnabled) {
                setPermissionsTeamId($tenantId);
            }

            $roleData = [
                'name' => $rolePlusPermission['name'],
                'guard_name' => $rolePlusPermission['guard_name'],
            ];

            // Include tenant ID in role data (can be null for global roles)
            if ($tenancyEnabled && ! blank($teamForeignKey)) {
                $roleData[$teamForeignKey] = $tenantId;
            }

            $role = $roleModel::firstOrCreate($roleData);

            if (! blank($rolePlusPermission['permissions'])) {
                $permissionModels = collect($rolePlusPermission['permissions'])
                    ->map(fn ($permission) => $permissionModel::firstOrCreate([
                        'name' => $permission,
                        'guard_name' => $rolePlusPermission['guard_name'],
                    ]))
                    ->all();

                $role->syncPermissions($permissionModels);
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (blank($permissions = json_decode($directPermissions, true))) {
            return;
        }

        /** @var \Illuminate\Database\Eloquent\Model $permissionModel */
        $permissionModel = Utils::getPermissionModel();

        foreach ($permissions as $permission) {
            if ($permissionModel::whereName($permission['name'])->doesntExist()) {
                $permissionModel::create([
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name'],
                ]);
            }
        }
    }
}
