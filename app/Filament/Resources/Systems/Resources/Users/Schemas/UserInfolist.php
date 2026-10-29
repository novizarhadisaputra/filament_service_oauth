<?php

namespace App\Filament\Resources\Systems\Resources\Users\Schemas;

use Filament\Schemas\Schema;

/**
 * Class UserInfolist
 *
 * User Infolist.
 */
class UserInfolist
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
