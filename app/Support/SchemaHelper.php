<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class SchemaHelper
{
    /**
     * Get the table name properly prefixed with the oauth schema if running on PostgreSQL.
     */
    public static function oauth(string $table): string
    {
        return DB::connection()->getDriverName() === 'pgsql' ? "oauth.{$table}" : $table;
    }
}
