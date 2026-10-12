<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TwoFactorSetupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'secret' => $this->resource['secret'],
            'otpauth_url' => $this->resource['otpauth_url'],
            'qr_code_svg' => $this->resource['qr_code_svg'],
            'recovery_codes' => $this->resource['recovery_codes'],
        ];
    }
}
