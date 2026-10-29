<?php

namespace App\Filament\Resources\Systems\Resources\OAuthClients\Schemas;

use Filament\Schemas\Schema;

/**
 * Class OAuthClientForm
 *
 * O Auth Client Form.
 */
class OAuthClientForm
{
    /**
     * Execute Configure operation.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
