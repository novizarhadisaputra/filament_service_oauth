<?php

namespace App\Observers;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        if (empty($user->password)) {
            // Generate a secure random password if none is provided
            // In a real app, you might send this via email
            $user->password = Hash::make(Str::random(12));
        }
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Auto-attach to the current tenant if created within the App panel
        if (Filament::getCurrentPanel() && Filament::getCurrentPanel()->getId() === 'app' && $tenant = Filament::getTenant()) {
            $user->systems()->syncWithoutDetaching([$tenant->id]);
        }
    }
}
