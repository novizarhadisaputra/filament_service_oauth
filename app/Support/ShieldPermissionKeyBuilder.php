<?php

namespace App\Support;

use BezhanSalleh\FilamentShield\Facades\FilamentShield;

class ShieldPermissionKeyBuilder
{
    /**
     * Custom permission key composition builder for Filament Shield.
     */
    public function __invoke(string $entity, ?string $affix, string $subject, string $case, string $separator): string
    {
        // Custom permissions from external services (e.g., SIMRS/OAuth) — use exact raw string name
        if ($entity === 'custom') {
            return $subject;
        }

        // Standard Filament entities (Resources, Pages, Widgets) — use default key builder
        return FilamentShield::defaultPermissionKeyBuilder(
            affix: $affix ?? '',
            separator: $separator,
            subject: $subject,
            case: $case
        );
    }
}
