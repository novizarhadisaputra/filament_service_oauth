<?php

namespace App\Filament\App\Resources\Users\Schemas;

use App\Models\Role;
use App\Models\System;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        $systemParam = request()->route('system');
        $teamId = ($systemParam instanceof System ? $systemParam->id : $systemParam)
            ?? Filament::getTenant()?->id 
            ?? request()->route('tenant');

        if ($teamId) {
            setPermissionsTeamId($teamId);
        }

        return $schema
            ->components([
                Section::make('User Identification')
                    ->components([
                        Grid::make(3)
                            ->components([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('username')
                                    ->maxLength(255)
                                    ->unique(User::class, 'username', ignoreRecord: true),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->unique(User::class, 'email', ignoreRecord: true),
                            ]),
                    ]),
                Section::make('Access Control')
                    ->description('Assign system-specific roles to this user.')
                    ->components([
                        CheckboxList::make('roles')
                            ->options(function ($livewire) {
                                $parentSystem = method_exists($livewire, 'getParentRecord') ? $livewire->getParentRecord() : null;
                                $systemParam = request()->route('system');
                                $teamId = $parentSystem?->id
                                    ?? ($systemParam instanceof System ? $systemParam->id : $systemParam)
                                    ?? Filament::getTenant()?->id 
                                    ?? request()->route('tenant');

                                if ($teamId) {
                                    setPermissionsTeamId($teamId);
                                    return Role::where('team_id', $teamId)->pluck('name', 'id');
                                }

                                return Role::pluck('name', 'id');
                            })
                            ->afterStateHydrated(function (CheckboxList $component, ?User $record, $livewire) {
                                if (! $record) {
                                    return;
                                }

                                $parentSystem = method_exists($livewire, 'getParentRecord') ? $livewire->getParentRecord() : null;
                                $systemParam = request()->route('system');
                                $teamId = $parentSystem?->id
                                    ?? ($systemParam instanceof System ? $systemParam->id : $systemParam)
                                    ?? Filament::getTenant()?->id 
                                    ?? request()->route('tenant');

                                if ($teamId) {
                                    setPermissionsTeamId($teamId);
                                    $roleIds = $record->roles()->where('roles.team_id', $teamId)->pluck('roles.id')->toArray();
                                } else {
                                    $roleIds = $record->roles->pluck('id')->toArray();
                                }

                                $component->state($roleIds);
                            })
                            ->dehydrated(true)
                            ->required()
                            ->columns(3),
                    ]),
            ]);
    }
}
