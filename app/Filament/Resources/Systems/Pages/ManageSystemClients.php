<?php

namespace App\Filament\Resources\Systems\Pages;

use App\Filament\Resources\Systems\Resources\OAuthClients\SystemsOAuthClientResource;
use App\Filament\Resources\Systems\SystemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Table;

/**
 * Class ManageSystemClients
 *
 * Manage System Clients.
 */
class ManageSystemClients extends ManageRelatedRecords
{
    protected static string $resource = SystemResource::class;

    protected static string $relationship = 'clients';

    protected static ?string $relatedResource = SystemsOAuthClientResource::class;

    protected static ?string $title = 'OAuth Clients';

    protected static ?string $navigationLabel = 'OAuth Clients';

    protected static ?string $slug = 'oauth-clients';

    /**
     * Execute Table operation.
     *
     * @param Table $table
     * @return Table
     */
    public function table(Table $table): Table
    {
        return SystemsOAuthClientResource::table($table)
            ->headerActions([
            ]);
    }

    /**
     * Execute Get Breadcrumbs operation.
     *
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();
        $system = $this->getOwnerRecord();

        return [
            $resource::getUrl() => $resource::getBreadcrumb(),
            $resource::getUrl('edit', ['record' => $system]) => $system->name,
            'OAuth Clients',
        ];
    }
}
