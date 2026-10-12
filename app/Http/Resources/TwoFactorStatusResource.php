<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\User $resource
 */
class TwoFactorStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'enabled' => $this->resource->hasTwoFactorEnabled(),
            'confirmed_at' => $this->resource->two_factor_confirmed_at?->toIso8601String(),
            'has_recovery_codes' => ! empty($this->resource->two_factor_recovery_codes),
            'recovery_codes_count' => is_array($this->resource->two_factor_recovery_codes) ? count($this->resource->two_factor_recovery_codes) : 0,
        ];
    }
}
