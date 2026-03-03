<?php

namespace App\Observers;

use App\Models\System;
use Illuminate\Support\Str;

class SystemObserver
{
    /**
     * Handle the System "creating" event.
     */
    public function creating(System $system): void
    {
        if (! $system->slug) {
            $system->slug = Str::slug($system->name);
        }

        if (! $system->system_code) {
            $system->system_code = 'SYS-'.strtoupper(Str::random(8));
        }
    }

    /**
     * Handle the System "updating" event.
     */
    public function updating(System $system): void
    {
        if ($system->isDirty('name') && ! $system->isDirty('slug')) {
            $system->slug = Str::slug($system->name);
        }
    }
}
