<?php

namespace App\Support;

use App\Models\Permission;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;

class ShieldCustomPermissionsLoader
{
    /**
     * Register dynamic custom permissions and key composition for Filament Shield.
     */
    public static function register(): void
    {
        // 1. Custom Permission Key Composition
        FilamentShield::buildPermissionKeyUsing(
            (new ShieldPermissionKeyBuilder)->__invoke(...)
        );

        // 2. Dynamic Custom Permissions loading from Database
        try {
            $permissions = Permission::pluck('name', 'name')->toArray();
            if (! empty($permissions)) {
                config()->set('filament-shield.custom_permissions', $permissions);
            }
        } catch (\Throwable $e) {
            // Ignore during early bootstrap/migrations
        }
    }
}
