<?php

namespace App\Filament\App\Resources\OAuthClients\Tables;

use App\Models\OAuthClient;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class OAuthClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                TextColumn::make('client_id')
                    ->label('Client ID')
                    ->searchable()
                    ->sortable()
                    ->fontFamily('mono')
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('client_secret')
                    ->label('Client Secret')
                    ->fontFamily('mono')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable(),
                IconColumn::make('revoked')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('revoke')
                    ->action(fn (OAuthClient $record) => $record->update(['revoked' => true]))
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->visible(fn (OAuthClient $record) => ! $record->revoked && auth()->user()->can('revoke', $record)),
                Action::make('regenerateSecret')
                    ->action(fn (OAuthClient $record) => $record->update(['client_secret' => Str::random(40)]))
                    ->requiresConfirmation()
                    ->color('warning')
                    ->icon('heroicon-o-key')
                    ->visible(fn (OAuthClient $record) => auth()->user()->can('regenerateSecret', $record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
