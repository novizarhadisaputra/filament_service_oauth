<?php

namespace App\Filament\Resources\Systems\Pages;

use App\Filament\Resources\Systems\Resources\Users\UserResource;
use App\Filament\Resources\Systems\SystemResource;
use App\Models\User;
use Filament\Actions\AttachAction;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ManageSystemUsers extends ManageRelatedRecords
{
    protected static string $resource = SystemResource::class;

    protected static string $relationship = 'users';

    protected static ?string $relatedResource = UserResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                AttachAction::make(),
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
