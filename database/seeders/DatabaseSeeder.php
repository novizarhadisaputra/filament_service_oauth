<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\System;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Run ShieldSeeder and OAuthClientSeeder first
        $this->call([
            ShieldSeeder::class,
            OAuthClientSeeder::class,
        ]);

        $simrsTenantId = '019cb7e2-040b-71fd-aecc-8cf5ba16b891';
        
        // 2. Define users with their specific roles and metadata
        $users = [
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@tarakan.local',
                'username' => 'superadmin',
                'password' => Hash::make('password'),
                'role' => 'SuperAdmin',
                'tenant' => '_global',
                'metadata' => [],
            ],
            [
                'name' => 'System Administrator',
                'email' => 'admin@tarakan.local',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'tenant' => $simrsTenantId,
                'metadata' => [],
            ],
            [
                'name' => 'Dr. Andi Saputra',
                'email' => 'doctor@tarakan.local',
                'username' => 'doctor',
                'password' => Hash::make('password'),
                'role' => 'Doctor',
                'tenant' => $simrsTenantId,
                'metadata' => [
                    'paramedic_id' => 'MD-00017',
                ],
            ],
            [
                'name' => 'Ners Budi Santoso',
                'email' => 'nurse@tarakan.local',
                'username' => 'nurse',
                'password' => Hash::make('password'),
                'role' => 'Nurse',
                'tenant' => $simrsTenantId,
                'metadata' => [
                    'employee_number' => 'NRS-001',
                ],
            ],
            [
                'name' => 'Apoteker Clara',
                'email' => 'pharmacist@tarakan.local',
                'username' => 'pharmacist',
                'password' => Hash::make('password'),
                'role' => 'Pharmacist',
                'tenant' => $simrsTenantId,
                'metadata' => [],
            ],
            [
                'name' => 'Registrar Doni',
                'email' => 'operator@tarakan.local',
                'username' => 'operator',
                'password' => Hash::make('password'),
                'role' => 'Operator',
                'tenant' => $simrsTenantId,
                'metadata' => [],
            ],
        ];

        foreach ($users as $userData) {
            $roleName = $userData['role'];
            $tenantId = $userData['tenant'];
            unset($userData['role'], $userData['tenant']);

            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            // Attach user to SIMRS tenant (system_user table)
            if ($tenantId !== '_global') {
                $user->systems()->syncWithoutDetaching([$simrsTenantId]);
            } else {
                // Global users can access all systems
                $user->systems()->syncWithoutDetaching(System::pluck('id')->toArray());
            }

            // Assign role per tenant/context
            $contextId = $tenantId === '_global' ? null : $tenantId;
            setPermissionsTeamId($contextId);
            $user->syncRoles([$roleName]);
        }
    }
}

