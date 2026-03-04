<?php

namespace App\Filament\App\Resources\OAuthClients\Schemas;

use App\Enums\GrantType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OAuthClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->components([
                        TextInput::make('name')
                            ->placeholder('My Application')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('redirect_uris')
                            ->label('Redirect URLs')
                            ->placeholder('https://app.com/callback, https://app.com/auth')
                            ->helperText('Comma-separated list of allowed redirect URIs.')
                            ->required()
                            ->maxLength(255),
                    ]),
                Section::make('Grant Configuration')
                    ->description('Specify how this client can authenticate.')
                    ->components([
                        Select::make('grant_types')
                            ->label('Grant Types')
                            ->options(GrantType::class)
                            ->multiple()
                            ->required(),
                        Grid::make(2)
                            ->components([
                                Toggle::make('password_client')
                                    ->label('Password Grant Client'),
                                Toggle::make('personal_access_client')
                                    ->label('Personal Access Client'),
                            ]),
                    ]),
            ]);
    }
}
