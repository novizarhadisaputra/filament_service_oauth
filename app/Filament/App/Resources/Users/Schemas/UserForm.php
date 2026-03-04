<?php

namespace App\Filament\App\Resources\Users\Schemas;

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
                            ->relationship('roles', 'name', function ($query) {
                                $teamId = Filament::getTenant()?->id ?? request()->route('system') ?? request()->route('record');

                                if ($teamId) {
                                    return $query->where('roles.team_id', $teamId);
                                }

                                return $query;
                            })
                            ->saveRelationshipsUsing(function (User $record, $state) {
                                $record->syncRoles($state);
                            })
                            ->required()
                            ->columns(3),
                    ]),
            ]);
    }
}
