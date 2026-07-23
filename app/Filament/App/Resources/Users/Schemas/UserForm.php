<?php

namespace App\Filament\App\Resources\Users\Schemas;

use App\Models\Role;
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
        $teamId = ($systemParam instanceof \App\Models\System ? $systemParam->id : $systemParam)
            ?? Filament::getTenant()?->id 
            ?? request()->route('tenant');

        if ($teamId) {
            setPermissionsTeamId($teamId);
        }

        return $schema
            ->components([
                Section::make('User Identification')
                    ->components([
                        Grid::make(2)
                            ->components([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
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
                                    ?? ($systemParam instanceof \App\Models\System ? $systemParam->id : $systemParam)
                                    ?? Filament::getTenant()?->id 
                                    ?? request()->route('tenant');

                                if ($teamId) {
                                    setPermissionsTeamId($teamId);
                                    return Role::where('team_id', $teamId)->pluck('name', 'id');
                                }

                                return Role::pluck('name', 'id');
                            })
                            ->loadStateFromRelationshipsUsing(function (User $record, $livewire) {
                                $parentSystem = method_exists($livewire, 'getParentRecord') ? $livewire->getParentRecord() : null;
                                $systemParam = request()->route('system');
                                $teamId = $parentSystem?->id
                                    ?? ($systemParam instanceof \App\Models\System ? $systemParam->id : $systemParam)
                                    ?? Filament::getTenant()?->id 
                                    ?? request()->route('tenant');

                                if ($teamId) {
                                    setPermissionsTeamId($teamId);
                                }

                                $record->unsetRelation('roles');

                                return $record->roles->pluck('id')->toArray();
                            })
                            ->required()
                            ->columns(3),
                    ]),
            ]);
    }
}
