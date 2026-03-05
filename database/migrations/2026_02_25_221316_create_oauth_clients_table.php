<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(\App\Support\SchemaHelper::oauth('oauth_clients'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('client_id')->unique();
            $table->nullableUuidMorphs('owner');
            $table->string('name');
            $table->string('client_secret')->nullable();
            $table->text('encrypted_secret')->nullable();
            $table->string('provider')->nullable();
            $table->text('redirect_uris');
            $table->text('grant_types')->nullable();
            $table->text('scopes')->nullable();
            $table->boolean('personal_access_client')->default(false);
            $table->boolean('password_client')->default(false);
            $table->boolean('revoked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(\App\Support\SchemaHelper::oauth('oauth_clients'));
    }

    /**
     * Get the migration connection name.
     */
    public function getConnection(): ?string
    {
        return $this->connection ?? config('passport.connection');
    }
};
