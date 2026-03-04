<?php

namespace App\Filament\Resources\Systems\Pages;

use App\Filament\Resources\Systems\SystemResource;
use App\Models\User;
use BackedEnum;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ManageSystemUsers extends ManageRelatedRecords
{
    protected static string $resource = SystemResource::class;

    protected static string $relationship = 'users';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    public function form(Schema $schema): Schema
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
                            ->relationship('roles', 'name', fn ($query) => $query->where('roles.team_id', $this->getOwnerRecord()->id))
                            ->saveRelationshipsUsing(function (User $record, $state) {
                                $record->syncRoles($state);
                            })
                            ->required()
                            ->columns(3),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles.name')
                    ->badge()
                    ->label('Roles'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
