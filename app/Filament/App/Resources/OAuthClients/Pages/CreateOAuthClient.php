<?php

namespace App\Filament\App\Resources\OAuthClients\Pages;

use App\Filament\App\Resources\OAuthClientResource;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Wizard\Step;

class CreateOAuthClient extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = OAuthClientResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('General Information')
                ->description('Provide the basic details for your OAuth client.')
                ->components([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('redirect_uris')
                        ->label('Redirect URLs')
                        ->placeholder('https://app.com/callback, https://app.com/auth')
                        ->helperText('Comma-separated list of allowed redirect URIs.')
                        ->required()
                        ->maxLength(255),
                ]),
            Step::make('Grant Configuration')
                ->description('Select the allowed grant types for this client.')
                ->components([
                    TextInput::make('grant_types')
                        ->label('Grant Types')
                        ->placeholder('password, authorization_code, refresh_token')
                        ->helperText('Comma-separated list of allowed grant types.')
                        ->required(),
                ]),
        ];
    }
}
