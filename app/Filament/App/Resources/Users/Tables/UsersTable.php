<?php

namespace App\Filament\App\Resources\Users\Tables;

use App\Models\Role;
use App\Models\System;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('username')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles')
                    ->badge()
                    ->label('Roles')
                    ->getStateUsing(function (User $record, $livewire) {
                        $parentSystem = method_exists($livewire, 'getParentRecord') ? $livewire->getParentRecord() : null;
                        $systemParam = request()->route('system');
                        $teamId = $parentSystem?->id
                            ?? ($systemParam instanceof System ? $systemParam->id : $systemParam)
                            ?? Filament::getTenant()?->id 
                            ?? request()->route('tenant');

                        if ($teamId) {
                            setPermissionsTeamId($teamId);
                            return $record->roles()
                                ->where(function ($q) use ($teamId) {
                                    $q->where('roles.team_id', $teamId)
                                      ->orWhereNull('roles.team_id');
                                })
                                ->pluck('name')
                                ->toArray();
                        }

                        return Role::whereIn(
                            'id',
                            DB::table(config('permission.table_names.model_has_roles'))
                                ->where('model_id', $record->id)
                                ->pluck('role_id')
                        )->pluck('name')->toArray();
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
