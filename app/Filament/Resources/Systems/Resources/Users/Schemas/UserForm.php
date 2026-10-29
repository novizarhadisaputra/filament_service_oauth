<?php

namespace App\Filament\Resources\Systems\Resources\Users\Schemas;

use Filament\Schemas\Schema;

/**
 * Class UserForm
 *
 * User Form.
 */
class UserForm
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
