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
            // Core System Administration
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@tarakan.local',
                'username' => 'superadmin',
                'password' => Hash::make('password'),
                'roles' => ['SuperAdmin'],
                'tenant' => null,
                'metadata' => [],
            ],
            [
                'name' => 'Heri Purnomo, Amd.Kom.',
                'email' => 'okejsb84@gmail.com',
                'username' => 'Heri.Purnomo',
                'password' => Hash::make('password'),
                'roles' => ['SuperAdmin'],
                'tenant' => null,
                'metadata' => [],
            ],
            [
                'name' => 'Ferdy Wijaya, S.Kom',
                'email' => 'ferdiee045@gmail.com',
                'username' => 'Ferdy.Wijaya',
                'password' => Hash::make('password'),
                'roles' => ['Admin'],
                'tenant' => $simrsTenantId,
                'metadata' => [],
            ],

            // Clinical Doctors (Role: Doctor)
            [
                'name' => 'dr. Maria Irawati, Sp.PD-KGH, KIC',
                'email' => 'drmarias2005@yahoo.com',
                'username' => 'dr.Maria',
                'password' => Hash::make('123'),
                'roles' => ['Doctor'],
                'tenant' => $simrsTenantId,
                'metadata' => [
                    'paramedic_id' => 'MD-00127',
                ],
            ],
            [
                'name' => 'Dr. Andi Saputra',
                'email' => 'doctor@tarakan.local',
                'username' => 'doctor',
                'password' => Hash::make('password'),
                'roles' => ['Doctor'],
                'tenant' => $simrsTenantId,
                'metadata' => [
                    'paramedic_id' => 'MD-00017',
                ],
            ],
            [
                'name' => 'dr. Andika Rizki Lubis, Sp.Jp',
                'email' => 'alubis63@gmail.com',
                'username' => 'dr.andikaRL',
                'password' => Hash::make('password'),
                'roles' => ['Doctor'],
                'tenant' => $simrsTenantId,
                'metadata' => [
                    'paramedic_id' => 'MD-00108',
                ],
            ],
            [
                'name' => 'dr. Rino Meridian, Sp.B,(K)',
                'email' => 'rinomeridian1978@gmail.com',
                'username' => 'dr.Rino',
                'password' => Hash::make('password'),
                'roles' => ['Doctor'],
                'tenant' => $simrsTenantId,
                'metadata' => [
                    'paramedic_id' => 'MD-00095',
                ],
            ],
            [
                'name' => 'dr. Lasma Susi, SpMK',
                'email' => 'susi.juntak@gmail.com',
                'username' => 'dr.lasmasusi',
                'password' => Hash::make('password'),
                'roles' => ['Doctor', 'PPRA'],
                'tenant' => $simrsTenantId,
                'metadata' => [
                    'paramedic_id' => 'MD-00142',
                ],
            ],

            // Nursing Staff (Role: Nurse)
            [
                'name' => 'Ners Budi Santoso',
                'email' => 'nurse@tarakan.local',
                'username' => 'nurse',
                'password' => Hash::make('password'),
                'roles' => ['Nurse'],
                'tenant' => $simrsTenantId,
                'metadata' => [
                    'employee_number' => 'NRS-001',
                ],
            ],
            [
                'name' => 'Ramlawati, S.Kep, Ners',
                'email' => 'aikoramlawati@yahoo.co.id',
                'username' => 'Ramlawati',
                'password' => Hash::make('password'),
                'roles' => ['Nurse'],
                'tenant' => $simrsTenantId,
                'metadata' => [
                    'employee_number' => 'NRS-002',
                ],
            ],
            [
                'name' => 'Ainis Solekhah, S.Kep, Ners',
                'email' => 'ainis.newss@yahoo.com',
                'username' => 'Ainis.Sole',
                'password' => Hash::make('password'),
                'roles' => ['Nurse'],
                'tenant' => $simrsTenantId,
                'metadata' => [
                    'employee_number' => 'NRS-003',
                ],
            ],

            // Pharmacy Staff (Role: Pharmacist)
            [
                'name' => 'Apoteker Clara',
                'email' => 'pharmacist@tarakan.local',
                'username' => 'pharmacist',
                'password' => Hash::make('password'),
                'roles' => ['Pharmacist'],
                'tenant' => $simrsTenantId,
                'metadata' => [],
            ],
            [
                'name' => 'Aditya Pratama, Amd. Farm',
                'email' => 'Aditya.Pra@tarakan.local',
                'username' => 'Aditya.Pra',
                'password' => Hash::make('password'),
                'roles' => ['Pharmacist'],
                'tenant' => $simrsTenantId,
                'metadata' => [],
            ],

            // Front Office & Admission (Role: Operator)
            [
                'name' => 'Agus Wahyu Sejati',
                'email' => 'aguswahyusejti14@gmail.com',
                'username' => 'Agus.WS',
                'password' => Hash::make('password'),
                'roles' => ['Operator'],
                'tenant' => $simrsTenantId,
                'metadata' => [],
            ],

            // Medical Coder & Casemix Team (Role: MedicalCoder)
            [
                'name' => 'Ukfia Anggraini, S.Kom',
                'email' => 'ukfia.a@tarakan.local',
                'username' => 'Ukfia.A',
                'password' => Hash::make('password'),
                'roles' => ['MedicalCoder'],
                'tenant' => $simrsTenantId,
                'metadata' => ['person_id' => '2445'],
            ],
            [
                'name' => 'Pitra Wahyuni, AMd.RM',
                'email' => 'pitra.wahyu@tarakan.local',
                'username' => 'Pitra.Wahyu',
                'password' => Hash::make('password'),
                'roles' => ['MedicalCoder'],
                'tenant' => $simrsTenantId,
                'metadata' => ['person_id' => '807'],
            ],
            [
                'name' => 'Remista Situmeang, A.Md. RMIK',
                'email' => 'remista.s@tarakan.local',
                'username' => 'Remista.S',
                'password' => Hash::make('password'),
                'roles' => ['MedicalCoder'],
                'tenant' => $simrsTenantId,
                'metadata' => ['person_id' => '843'],
            ],
            [
                'name' => 'Yuni Marugun, A.Md Rmik',
                'email' => 'yuni.ma@tarakan.local',
                'username' => 'Yuni.MA',
                'password' => Hash::make('password'),
                'roles' => ['MedicalCoder'],
                'tenant' => $simrsTenantId,
                'metadata' => ['person_id' => '1120'],
            ],
            [
                'name' => 'Wulan Sari Marasito P, AMd.RM',
                'email' => 'wulan.sari@tarakan.local',
                'username' => 'Wulan.Sari',
                'password' => Hash::make('password'),
                'roles' => ['MedicalCoder'],
                'tenant' => $simrsTenantId,
                'metadata' => ['person_id' => '1092'],
            ],
            [
                'name' => 'Yohana Dwi Astuti, AMd.RM',
                'email' => 'yohana.dwi@tarakan.local',
                'username' => 'Yohana.Dwi',
                'password' => Hash::make('password'),
                'roles' => ['MedicalCoder'],
                'tenant' => $simrsTenantId,
                'metadata' => ['person_id' => '1109'],
            ],
            [
                'name' => 'Eka Amalia Wulandari, AMd.RM',
                'email' => 'ekaamalia0591@gmail.com',
                'username' => 'Eka.Amalia',
                'password' => Hash::make('password'),
                'roles' => ['MedicalCoder'],
                'tenant' => $simrsTenantId,
                'metadata' => ['person_id' => '405'],
            ],
            [
                'name' => 'Juwita Sari, AMd.RM',
                'email' => 'juwita.sar@tarakan.local',
                'username' => 'Juwita.Sar',
                'password' => Hash::make('password'),
                'roles' => ['MedicalCoder'],
                'tenant' => $simrsTenantId,
                'metadata' => ['person_id' => '592'],
            ],
            [
                'name' => 'Nilasari, SE',
                'email' => 'nilasari@tarakan.local',
                'username' => 'Nilasari',
                'password' => Hash::make('password'),
                'roles' => ['MedicalCoder'],
                'tenant' => $simrsTenantId,
                'metadata' => ['person_id' => '751'],
            ],
            [
                'name' => 'Uji Sektiawan, ST(Kom)',
                'email' => 'akusingpalinganyar@gmail.com',
                'username' => 'Uji.S',
                'password' => Hash::make('password'),
                'roles' => ['MedicalCoder'],
                'tenant' => $simrsTenantId,
                'metadata' => ['person_id' => '1052'],
            ],

            // Management, HR & Billing
            [
                'name' => 'Direktur Pelayanan Medis',
                'email' => 'management@tarakan.local',
                'username' => 'management',
                'password' => Hash::make('password'),
                'roles' => ['Management'],
                'tenant' => $simrsTenantId,
                'metadata' => [],
            ],
            [
                'name' => 'Staf SDM Jessica',
                'email' => 'hr@tarakan.local',
                'username' => 'hr',
                'password' => Hash::make('password'),
                'roles' => ['HR'],
                'tenant' => $simrsTenantId,
                'metadata' => [],
            ],
            [
                'name' => 'Anton',
                'email' => 'anton@tarakan.local',
                'username' => 'Anton',
                'password' => Hash::make('password'),
                'roles' => ['Billing'],
                'tenant' => $simrsTenantId,
                'metadata' => [],
            ],
            [
                'name' => 'Ahmad Firdaus, A.Md.G',
                'email' => 'ahmad.fird@tarakan.local',
                'username' => 'Ahmad.Fird',
                'password' => Hash::make('password'),
                'roles' => ['Dietitian'],
                'tenant' => $simrsTenantId,
                'metadata' => [],
            ],
        ];

        foreach ($users as $userData) {
            $roles = (array) $userData['roles'];
            $tenantId = $userData['tenant'];
            unset($userData['roles'], $userData['tenant']);

            $user = User::where('email', $userData['email'])
                ->orWhere('username', $userData['username'])
                ->first();

            if ($user) {
                $user->update($userData);
            } else {
                $user = User::create($userData);
            }

            // Attach user to systems (system_user table)
            if ($tenantId !== null) {
                $user->systems()->syncWithoutDetaching([$simrsTenantId]);
            } else {
                // Global users can access all systems
                $user->systems()->syncWithoutDetaching(System::pluck('id')->toArray());
            }

            // Assign role per tenant/context (null for global roles like SuperAdmin)
            setPermissionsTeamId($tenantId);
            $user->syncRoles($roles);
        }
    }
}

