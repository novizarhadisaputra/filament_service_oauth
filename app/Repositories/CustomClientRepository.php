<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;

class CustomClientRepository extends ClientRepository
{
    /**
     * Get a client by the given ID.
     * Overridden to support lookup by 'client_id' (string) or 'id' (UUID).
     */
    public function find(string|int $id): ?Client
    {
        return once(function () use ($id) {
            $query = Passport::client()->newQuery();
            
            if (Str::isUuid((string) $id)) {
                return $query->find($id);
            }

            return $query->where('client_id', $id)->first();
        });
    }
}
