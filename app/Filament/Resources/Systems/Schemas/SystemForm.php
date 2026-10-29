<?php

namespace App\Filament\Resources\Systems\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Class SystemForm
 *
 * System Form.
 */
class SystemForm
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
                Section::make('Global Identity')
                    ->description('General information about this system.')
                    ->components([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->rows(3),
                    ]),
            ]);
    }
}
