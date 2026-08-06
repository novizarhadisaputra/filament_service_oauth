<?php

declare(strict_types=1);

namespace App\Filament\App\Resources\Roles;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use App\Filament\App\Resources\Roles\Pages\CreateRole;
use App\Filament\App\Resources\Roles\Pages\EditRole;
use App\Filament\App\Resources\Roles\Pages\ListRoles;
use App\Filament\App\Resources\Roles\Pages\ViewRole;
use BezhanSalleh\FilamentShield\Support\Utils;
use BezhanSalleh\FilamentShield\Traits\HasShieldFormComponents;
use BezhanSalleh\PluginEssentials\Concerns\Resource as Essentials;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class RoleResource extends Resource
{
    use Essentials\BelongsToParent;
    use Essentials\BelongsToTenant;
    use Essentials\HasGlobalSearch;
    use Essentials\HasLabels;
    use Essentials\HasNavigation;
    use HasShieldFormComponents;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('filament-shield::filament-shield.field.name'))
                                    ->unique(
                                        ignoreRecord: true, /** @phpstan-ignore-next-line */
                                        modifyRuleUsing: fn (Unique $rule): Unique => Utils::isTenancyEnabled() ? $rule->where(Utils::getTenantModelForeignKey(), Filament::getTenant()?->id) : $rule
                                    )
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('guard_name')
                                    ->label(__('filament-shield::filament-shield.field.guard_name'))
                                    ->default(Utils::getFilamentAuthGuard())
                                    ->nullable()
                                    ->maxLength(255),

                                Select::make(config('permission.column_names.team_foreign_key'))
                                    ->label(__('filament-shield::filament-shield.field.team'))
                                    ->placeholder(__('filament-shield::filament-shield.field.team.placeholder'))
                                    /** @phpstan-ignore-next-line */
                                    ->default(Filament::getTenant()?->id)
                                    ->options(fn (): array => in_array(Utils::getTenantModel(), [null, '', '0'], true) ? [] : Utils::getTenantModel()::pluck('name', 'id')->toArray())
                                    ->visible(fn (): bool => static::shield()->isCentralApp() && Utils::isTenancyEnabled())
                                    ->dehydrated(fn (): bool => static::shield()->isCentralApp() && Utils::isTenancyEnabled()),
                                static::getSelectAllFormComponent(),

                            ])
                            ->columns([
                                'sm' => 2,
                                'lg' => 3,
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                static::getShieldFormComponents(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->weight(FontWeight::Medium)
                    ->label(__('filament-shield::filament-shield.column.name'))
                    ->formatStateUsing(fn (string $state): string => Str::headline($state))
                    ->searchable(),
                TextColumn::make('guard_name')
                    ->badge()
                    ->color('warning')
                    ->label(__('filament-shield::filament-shield.column.guard_name')),
                TextColumn::make('team.name')
                    ->default('Global')
                    ->badge()
                    ->color(fn (mixed $state): string => str($state)->contains('Global') ? 'gray' : 'primary')
                    ->label(__('filament-shield::filament-shield.column.team'))
                    ->searchable()
                    ->visible(fn (): bool => static::shield()->isCentralApp() && Utils::isTenancyEnabled()),
                TextColumn::make('permissions_count')
                    ->badge()
                    ->label(__('filament-shield::filament-shield.column.permissions'))
                    ->counts('permissions')
                    ->color('primary'),
                TextColumn::make('updated_at')
                    ->label(__('filament-shield::filament-shield.column.updated_at'))
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'view' => ViewRole::route('/{record}'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }

    public static function getModel(): string
    {
        return Utils::getRoleModel();
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return Utils::getResourceSlug();
    }

    public static function getCluster(): ?string
    {
        return Utils::getResourceCluster();
    }

    public static function getEssentialsPlugin(): ?FilamentShieldPlugin
    {
        return FilamentShieldPlugin::get();
    }

    public static function getTabFormComponentForCustomPermissions(): \Filament\Schemas\Components\Component
    {
        $groupedCustomPermissions = static::getGroupedCustomPermissions();
        $totalCount = collect($groupedCustomPermissions)->sum(fn (array $group): int => count($group['permissions']));

        $schema = collect($groupedCustomPermissions)
            ->map(function (array $group): \Filament\Schemas\Components\Section {
                $modelLabel = \Illuminate\Support\Str::headline($group['model']);

                return \Filament\Schemas\Components\Section::make($modelLabel)
                    ->compact()
                    ->schema([
                        static::getCheckboxListFormComponent(
                            name: 'custom_permissions_' . \Illuminate\Support\Str::snake($group['model']),
                            options: $group['permissions'],
                            searchable: false,
                            columns: static::shield()->getResourceCheckboxListColumns(),
                            columnSpan: static::shield()->getResourceCheckboxListColumnSpan()
                        ),
                    ])
                    ->columnSpan(static::shield()->getSectionColumnSpan())
                    ->collapsible();
            })
            ->values()
            ->toArray();

        return \Filament\Schemas\Components\Tabs\Tab::make('custom_permissions')
            ->label(__('filament-shield::filament-shield.custom'))
            ->visible(fn (): bool => Utils::isCustomPermissionTabEnabled() && $totalCount > 0)
            ->badge($totalCount)
            ->schema([
                \Filament\Schemas\Components\Grid::make()
                    ->schema($schema)
                    ->columns(static::shield()->getGridColumns()),
            ]);
    }

    protected static function getGroupedCustomPermissions(): array
    {
        $allPermissions = \App\Models\Permission::pluck('name', 'name')->toArray();
        $resourcePermissions = array_keys(\BezhanSalleh\FilamentShield\Facades\FilamentShield::getAllResourcePermissionsWithLabels());

        $customPermissions = array_diff($allPermissions, $resourcePermissions);

        $grouped = [];
        foreach ($customPermissions as $perm) {
            if (str_contains($perm, ':')) {
                [$action, $subject] = explode(':', $perm, 2);
            } else {
                $action = $perm;
                $subject = $perm;
            }

            if (str_starts_with($subject, 'MedicationReceive')) {
                $subject = 'MedicationReceive';
            }

            $actionLabel = \Illuminate\Support\Str::of($action)->headline()->toString();
            $grouped[$subject]['model'] = $subject;
            $grouped[$subject]['permissions'][$perm] = $actionLabel;
        }

        return $grouped;
    }
}
