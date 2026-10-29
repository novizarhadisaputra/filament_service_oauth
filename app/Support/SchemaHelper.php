<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Class SchemaHelper
 *
 * Schema Helper.
 */
class SchemaHelper
{
    /**
     * Get the table name properly prefixed with the oauth schema if running on PostgreSQL.
     * @param string $table
     * @return string
     */
    public static function oauth(string $table): string
    {
        return DB::connection()->getDriverName() === 'pgsql' ? "oauth.{$table}" : $table;
    }
}
