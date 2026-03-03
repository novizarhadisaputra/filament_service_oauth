<?php

namespace App\Observers;

use App\Models\OAuthClient;
use App\Models\System;
use Filament\Facades\Filament;
use Illuminate\Support\Str;

class OAuthClientObserver
{
    /**
     * Handle the OAuthClient "creating" event.
     */
    public function creating(OAuthClient $client): void
    {
        if (! $client->id) {
            $client->id = (string) Str::uuid();
        }

        if (! $client->client_id) {
            $client->client_id = (string) Str::random(40);
        }

        if (! $client->client_secret) {
            $client->client_secret = (string) Str::random(40);
        }

        if (! $client->owner_id && $tenant = Filament::getTenant()) {
            $client->owner_id = $tenant->id;
            $client->owner_type = System::class;
        }

        if ($client->revoked === null) {
            $client->revoked = false;
        }

        $this->ensureArrayFields($client);
    }

    /**
     * Handle the OAuthClient "updating" event.
     */
    public function updating(OAuthClient $client): void
    {
        $this->ensureArrayFields($client);
    }

    /**
     * Ensure redirect_uris and grant_types are arrays if strings are provided.
     */
    protected function ensureArrayFields(OAuthClient $client): void
    {
        $attributes = $client->getAttributes();
        $fields = ['redirect_uris', 'grant_types'];

        foreach ($fields as $field) {
            $value = $attributes[$field] ?? null;

            if (is_string($value)) {
                // Try to decode. If it returns another JSON string, decode again (recursive).
                // If it returns an array, use it. If it returns a plain string, explode it.
                $decoded = json_decode($value, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    if (is_array($decoded)) {
                        $client->setAttribute($field, array_values(array_filter($decoded)));
                    } else {
                        // It was a JSON encoded string, let's treat it as the plain value
                        $client->setAttribute($field, array_values(array_filter(array_map('trim', explode(',', $decoded)))));
                    }
                } else {
                    // Plain string
                    $client->setAttribute($field, array_values(array_filter(array_map('trim', explode(',', $value)))));
                }
            }
        }
    }
}
