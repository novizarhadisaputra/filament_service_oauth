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
        
        // Seed users with updated PascalCase roles
        $users = '[{"id":"019cb7e2-02ee-7163-a70d-657bab8ac83b","name":"Test User","email":"test@example.com","email_verified_at":"2026-03-04T08:06:08.000000Z","created_at":"2026-03-04T08:06:08.000000Z","updated_at":"2026-03-04T08:06:08.000000Z","username":"test@example.com","password":"$2y$12$9VwN41imbu\\/iHdp6MwPPCu7\\/RjLPMjYicVSF9FnwHBluUV0RxRg\\/C","tenant_roles":{"_global":["SuperAdmin"]},"tenant_permissions":[]},{"id":"019cb7e2-03f7-7065-a656-c4a736e446b1","name":"Global Super Admin","email":"super-admin@health.id","email_verified_at":null,"created_at":"2026-03-04T08:06:08.000000Z","updated_at":"2026-03-04T08:06:08.000000Z","username":null,"password":"$2y$12$d55YMLsGZXzFXWCbElDgt.2diPk4d3chD5KiS31AswzixqzZqW15O","tenant_roles":{"_global":["SuperAdmin"]},"tenant_permissions":[]},{"id":"019cb7e2-04f7-708c-a7d8-cac9b8a6674e","name":"Admin SIMRS","email":"admin-simrs@health.id","email_verified_at":null,"created_at":"2026-03-04T08:06:08.000000Z","updated_at":"2026-03-04T08:06:08.000000Z","username":null,"password":"$2y$12$TUCXyoN4kQlkRHTk5XNCteE5xUAMf0k4Bzyhweq5d\\/pBAX.W9FXny","tenant_roles":{"019cb7e2-040b-71fd-aecc-8cf5ba16b891":["Admin"]},"tenant_permissions":[]},{"id":"019cb7e2-05f2-7388-a4bc-683168bfa7b4","name":"Admin E-Kinerja","email":"admin-e-kinerja@health.id","email_verified_at":null,"created_at":"2026-03-04T08:06:09.000000Z","updated_at":"2026-03-04T08:06:09.000000Z","username":null,"password":"$2y$12$eci2V072sigYVsFZ0yyNwuKjbXUhL8KB.tXqalYfbpIG7zOEOlscS","tenant_roles":{"019cb7e2-0508-73a1-84b6-a4f1e0118970":["Admin"]},"tenant_permissions":[]},{"id":"019cb7e2-06ec-703c-809c-c377d71406ce","name":"Admin Absensi Online","email":"admin-absensi@health.id","email_verified_at":null,"created_at":"2026-03-04T08:06:09.000000Z","updated_at":"2026-03-04T08:06:09.000000Z","username":null,"password":"$2y$12$5Fzd6XVRcRgce59l64SBYuD1y8E5d5ZrZ.QMqb5rUQ4zYgdfnbg2S","tenant_roles":{"019cb7e2-0601-72bc-b53a-67fcdd8e3782":["Admin"]},"tenant_permissions":[]},{"id":"019cb7e2-07ec-703c-809c-c377d71406ce","name":"Pharmacy User","email":"pharmacy@health.id","email_verified_at":null,"created_at":"2026-03-04T08:06:09.000000Z","updated_at":"2026-03-04T08:06:09.000000Z","username":null,"password":"$2y$12$9VwN41imbu\\/iHdp6MwPPCu7\\/RjLPMjYicVSF9FnwHBluUV0RxRg\\/C","tenant_roles":{"019cb7e2-040b-71fd-aecc-8cf5ba16b891":["Pharmacist"]},"tenant_permissions":[]}]';
        $userTenantPivot = '[]';
        
        // Seed roles with permissions (matching backend RolesAndPermissionsSeeder exactly)
        $rolesWithPermissions = '[
            {
                "name": "SuperAdmin",
                "guard_name": "web",
                "team_id": null,
                "permissions": [
                    "ViewAny:OAuthClient","View:OAuthClient","Create:OAuthClient","Update:OAuthClient","Delete:OAuthClient",
                    "ViewAny:User","View:User","Create:User","Update:User","Delete:User",
                    "ViewAny:Role","View:Role","Create:Role","Update:Role","Delete:Role","Sync:Role",
                    "ViewAny:Education","View:Education","Create:Education","Update:Education","Delete:Education","Print:Education",
                    "ViewAny:InternalReferral","View:InternalReferral","Create:InternalReferral","Update:InternalReferral","Delete:InternalReferral","Print:InternalReferral","Void:InternalReferral","Approve:InternalReferral",
                    "ViewAny:SickLetter","View:SickLetter","Create:SickLetter","Update:SickLetter","Delete:SickLetter","Print:SickLetter","Void:SickLetter","Sign:SickLetter",
                    "ViewAny:Soap","View:Soap","Create:Soap","Create:ProgressNoteSoap","Create:PPANoteSoap","Update:Soap","Delete:Soap","Print:Soap","Sign:Soap","Audit:Soap","FullAccess:Soap",
                    "ViewAny:VitalSign","View:VitalSign","Create:VitalSign","Update:VitalSign","Verify:VitalSign",
                    "ViewAny:Prescription","View:Prescription","Create:Prescription","Update:Prescription","Delete:Prescription","Print:Prescription","Void:Prescription","Review:Prescription","Dispense:Prescription","Verify:Prescription","AccessAllDepots:Prescription",
                    "ViewAny:ExamOrder","View:ExamOrder","Create:ExamOrder","Update:ExamOrder","Delete:ExamOrder","Print:ExamOrder","Void:ExamOrder","Complete:ExamOrder","Approve:ExamOrder",
                    "ViewAny:Assessment","View:Assessment","Create:Assessment","Update:Assessment","Delete:Assessment","Sign:Assessment",
                    "ViewAny:HealthRecord","View:HealthRecord",
                    "ViewAny:CarePlan","View:CarePlan","Create:CarePlan","Update:CarePlan","Delete:CarePlan",
                    "ViewAny:Scheduling","View:Scheduling","Create:Scheduling","Update:Scheduling","Delete:Scheduling",
                    "ViewAny:Medication","View:Medication",
                    "ViewAny:KioskQueue","View:KioskQueue","Create:KioskQueue","Update:KioskQueue","Delete:KioskQueue",
                    "ViewAny:Registration","View:Registration","Create:Registration","Update:Registration","Delete:Registration","Print:Registration",
                    "ViewAny:Bed","View:Bed","Update:Bed",
                    "ViewAny:PatientTransfer","View:PatientTransfer","Create:PatientTransfer","Update:PatientTransfer",
                    "ViewAny:Invoices","View:Invoices","Create:Invoices","Update:Invoices","Print:Invoices",
                    "ViewAny:Claim","View:Claim","Create:Claim","Update:Claim",
                    "ViewAny:MealOrder","View:MealOrder","Create:MealOrder","Update:MealOrder",
                    "ViewAny:Department","View:Department",
                    "ViewAny:Inventory","View:Inventory","Create:Inventory","Update:Inventory","Delete:Inventory","Approve:Inventory","Transfer:Inventory",
                    "ViewAny:Asset","View:Asset","Update:Asset",
                    "View:Audit",
                    "Manage:Cache",
                    "ViewAny:MedicationReceive","Approve:MedicationReceive","Realize:MedicationReceiveUsed",
                    "ViewAny:QuestionForm","View:QuestionForm","Create:QuestionForm","Update:QuestionForm","Delete:QuestionForm",
                    "ViewAny:AppParameter","Update:AppParameter",
                    "ViewAny:Ppra","Approve:Ppra","Reject:Ppra","Delete:Ppra"
                ]
            },
            {
                "name": "Doctor",
                "guard_name": "web",
                "team_id": "019cb7e2-040b-71fd-aecc-8cf5ba16b891",
                "permissions": [
                    "ViewAny:Education","View:Education","Create:Education","Update:Education","Delete:Education","Print:Education",
                    "ViewAny:InternalReferral","View:InternalReferral","Create:InternalReferral","Update:InternalReferral","Delete:InternalReferral","Print:InternalReferral","Void:InternalReferral",
                    "ViewAny:SickLetter","View:SickLetter","Create:SickLetter","Update:SickLetter","Delete:SickLetter","Print:SickLetter","Void:SickLetter","Sign:SickLetter",
                    "ViewAny:Soap","View:Soap","Create:ProgressNoteSoap","Update:Soap","Delete:Soap","Print:Soap","Sign:Soap",
                    "ViewAny:VitalSign","View:VitalSign","Create:VitalSign","Update:VitalSign",
                    "ViewAny:Prescription","View:Prescription","Create:Prescription","Update:Prescription","Void:Prescription","Print:Prescription",
                    "ViewAny:ExamOrder","View:ExamOrder","Create:ExamOrder","Update:ExamOrder","Void:ExamOrder","Print:ExamOrder","Approve:ExamOrder",
                    "ViewAny:Assessment","View:Assessment","Create:Assessment","Update:Assessment","Delete:Assessment","Sign:Assessment",
                    "ViewAny:HealthRecord","View:HealthRecord",
                    "ViewAny:CarePlan","View:CarePlan","Create:CarePlan","Update:CarePlan",
                    "ViewAny:Scheduling","View:Scheduling","Create:Scheduling","Update:Scheduling","Delete:Scheduling",
                    "ViewAny:Medication","View:Medication",
                    "ViewAny:Bed","ViewAny:PatientTransfer","View:PatientTransfer"
                ]
            },
            {
                "name": "Nurse",
                "guard_name": "web",
                "team_id": "019cb7e2-040b-71fd-aecc-8cf5ba16b891",
                "permissions": [
                    "ViewAny:Education","View:Education","Create:Education",
                    "ViewAny:InternalReferral","View:InternalReferral",
                    "ViewAny:SickLetter","View:SickLetter",
                    "ViewAny:Soap","View:Soap","Create:PPANoteSoap",
                    "ViewAny:VitalSign","View:VitalSign","Create:VitalSign","Update:VitalSign","Verify:VitalSign",
                    "ViewAny:Prescription","View:Prescription","Verify:Prescription",
                    "ViewAny:ExamOrder","View:ExamOrder",
                    "ViewAny:Assessment","View:Assessment","Create:Assessment","Update:Assessment",
                    "ViewAny:HealthRecord","View:HealthRecord",
                    "ViewAny:CarePlan","View:CarePlan","Create:CarePlan","Update:CarePlan",
                    "ViewAny:Scheduling","View:Scheduling",
                    "ViewAny:Medication","View:Medication",
                    "ViewAny:Bed","View:Bed","Update:Bed",
                    "ViewAny:PatientTransfer","View:PatientTransfer","Create:PatientTransfer","Update:PatientTransfer",
                    "ViewAny:MedicationReceive","Approve:MedicationReceive","Realize:MedicationReceiveUsed"
                ]
            },
            {
                "name": "Pharmacist",
                "guard_name": "web",
                "team_id": "019cb7e2-040b-71fd-aecc-8cf5ba16b891",
                "permissions": [
                    "ViewAny:Education","View:Education",
                    "ViewAny:Soap","View:Soap",
                    "ViewAny:Prescription","View:Prescription","Review:Prescription","Dispense:Prescription","Verify:Prescription","Print:Prescription",
                    "ViewAny:Medication","View:Medication",
                    "ViewAny:Inventory","View:Inventory","Create:Inventory","Update:Inventory","Approve:Inventory","Transfer:Inventory",
                    "ViewAny:MedicationReceive","Approve:MedicationReceive"
                ]
            },
            {
                "name": "Dietitian",
                "guard_name": "web",
                "team_id": "019cb7e2-040b-71fd-aecc-8cf5ba16b891",
                "permissions": [
                    "ViewAny:Education","View:Education",
                    "ViewAny:Soap","View:Soap",
                    "ViewAny:Assessment","View:Assessment",
                    "ViewAny:CarePlan","View:CarePlan","Create:CarePlan","Update:CarePlan",
                    "ViewAny:Medication","View:Medication",
                    "ViewAny:MealOrder","View:MealOrder","Create:MealOrder","Update:MealOrder"
                ]
            },
            {
                "name": "Admin",
                "guard_name": "web",
                "team_id": "019cb7e2-040b-71fd-aecc-8cf5ba16b891",
                "permissions": [
                    "ViewAny:User","View:User","Create:User","Update:User",
                    "ViewAny:Role","View:Role","Create:Role","Update:Role","Sync:Role",
                    "ViewAny:OAuthClient","View:OAuthClient","Create:OAuthClient","Update:OAuthClient",
                    "ViewAny:Invoices","View:Invoices","Create:Invoices","Update:Invoices","Print:Invoices",
                    "ViewAny:Claim","View:Claim","Create:Claim","Update:Claim",
                    "ViewAny:Inventory","View:Inventory","Create:Inventory","Update:Inventory","Approve:Inventory","Transfer:Inventory",
                    "AccessAllDepots:Prescription",
                    "Manage:Cache",
                    "ViewAny:QuestionForm","View:QuestionForm","Create:QuestionForm","Update:QuestionForm","Delete:QuestionForm",
                    "ViewAny:AppParameter","Update:AppParameter"
                ]
            },
            {
                "name": "Operator",
                "guard_name": "web",
                "team_id": "019cb7e2-040b-71fd-aecc-8cf5ba16b891",
                "permissions": [
                    "ViewAny:User","View:User",
                    "ViewAny:InternalReferral","View:InternalReferral",
                    "ViewAny:Scheduling","View:Scheduling","Create:Scheduling","Update:Scheduling",
                    "ViewAny:KioskQueue","View:KioskQueue","Create:KioskQueue","Update:KioskQueue",
                    "ViewAny:Registration","View:Registration","Create:Registration","Update:Registration","Print:Registration",
                    "ViewAny:Bed","View:Bed"
                ]
            },
            {
                "name": "User",
                "guard_name": "web",
                "team_id": "019cb7e2-040b-71fd-aecc-8cf5ba16b891",
                "permissions": [
                    "View:User"
                ]
            },
            {
                "name": "Admin",
                "guard_name": "web",
                "team_id": "019cb7e2-0508-73a1-84b6-a4f1e0118970",
                "permissions": []
            },
            {
                "name": "Operator",
                "guard_name": "web",
                "team_id": "019cb7e2-0508-73a1-84b6-a4f1e0118970",
                "permissions": []
            },
            {
                "name": "User",
                "guard_name": "web",
                "team_id": "019cb7e2-0508-73a1-84b6-a4f1e0118970",
                "permissions": []
            },
            {
                "name": "Admin",
                "guard_name": "web",
                "team_id": "019cb7e2-0601-72bc-b53a-67fcdd8e3782",
                "permissions": []
            },
            {
                "name": "Operator",
                "guard_name": "web",
                "team_id": "019cb7e2-0601-72bc-b53a-67fcdd8e3782",
                "permissions": []
            },
            {
                "name": "User",
                "guard_name": "web",
                "team_id": "019cb7e2-0601-72bc-b53a-67fcdd8e3782",
                "permissions": []
            },
            {
                "name": "PPRA",
                "guard_name": "web",
                "team_id": "019cb7e2-040b-71fd-aecc-8cf5ba16b891",
                "permissions": [
                    "ViewAny:Ppra", "Approve:Ppra", "Reject:Ppra", "Delete:Ppra",
                    "ViewAny:Prescription", "View:Prescription",
                    "ViewAny:Soap", "View:Soap"
                ]
            }
        ]';
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

            $role = $roleModel::updateOrCreate(
                [
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                    'team_id' => $tenantId,
                ],
                $roleData
            );

            if (! blank($rolePlusPermission['permissions'])) {
                $permissionModels = collect($rolePlusPermission['permissions'])
                    ->map(fn ($permission) => $permissionModel::updateOrCreate([
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
