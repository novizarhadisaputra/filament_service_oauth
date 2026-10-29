<?php

namespace App\Support;

use BezhanSalleh\FilamentShield\Facades\FilamentShield;

/**
 * Class ShieldPermissionKeyBuilder
 *
 * Shield Permission Key Builder.
 */
class ShieldPermissionKeyBuilder
{
    /**
     * Custom permission key composition builder for Filament Shield.
     * @param string $entity
     * @param ?string $affix
     * @param string $subject
     * @param string $case
     * @param string $separator
     * @return string
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
