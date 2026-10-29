<?php

namespace App\Filament\Resources\Systems\Resources\OAuthClients\Schemas;

use Filament\Schemas\Schema;

/**
 * Class OAuthClientInfolist
 *
 * O Auth Client Infolist.
 */
class OAuthClientInfolist
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
