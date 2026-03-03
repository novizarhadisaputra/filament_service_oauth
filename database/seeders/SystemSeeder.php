<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $systems = [
            ['name' => 'SIMRS', 'slug' => 'simrs'],
            ['name' => 'E-Kinerja', 'slug' => 'e-kinerja'],
            ['name' => 'Absensi Online', 'slug' => 'absensi'],
        ];

        foreach ($systems as $sysData) {
            $system = \App\Models\System::firstOrCreate(
                ['slug' => $sysData['slug']],
                ['name' => $sysData['name']]
            );

            // Set the team context for role/permission creation
            setPermissionsTeamId($system->id);

            // Create system-specific roles
            foreach (['admin', 'operator', 'user'] as $roleName) {
                // Ensure we use the custom Role model with UUID
                \App\Models\Role::firstOrCreate([
                    'name' => $roleName,
                    'guard_name' => 'web',
                    config('permission.column_names.team_foreign_key') => $system->id,
                ]);
            }
        }

        // Reset team context
        setPermissionsTeamId(null);
    }
}
