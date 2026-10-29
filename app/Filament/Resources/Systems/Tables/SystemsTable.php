<?php

namespace App\Filament\Resources\Systems\Tables;

use App\Models\System;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Class SystemsTable
 *
 * Systems Table.
 */
class SystemsTable
{
    /**
     * Execute Configure operation.
     *
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make('activate')
                    ->action(fn (System $record) => $record->update(['is_active' => true]))
                    ->color('success')
                    ->visible(fn (System $record) => ! $record->is_active && auth()->user()->can('activate', $record)),
                Action::make('deactivate')
                    ->action(fn (System $record) => $record->update(['is_active' => false]))
                    ->color('danger')
                    ->visible(fn (System $record) => $record->is_active && auth()->user()->can('deactivate', $record)),
            ]);
    }
}
