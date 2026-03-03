<?php

namespace App\Filament\Resources\Systems\Pages;

use App\Filament\Resources\Systems\SystemResource;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Wizard\Step;

class CreateSystem extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = SystemResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('System Identity')
                ->description('Provide the unique identity for your system.')
                ->components([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                ]),
            Step::make('Details & Confirmation')
                ->description('Add a description and confirm the registration.')
                ->components([
                    Textarea::make('description')
                        ->columnSpanFull()
                        ->rows(5),
                ]),
        ];
    }
}
