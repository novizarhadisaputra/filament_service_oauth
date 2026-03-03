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
        Schema::create(\App\Support\SchemaHelper::oauth('system_user'), function (Blueprint $table) {
            $table->foreignUuid('system_id')->constrained(\App\Support\SchemaHelper::oauth('systems'))->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained(\App\Support\SchemaHelper::oauth('users'))->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['system_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(\App\Support\SchemaHelper::oauth('system_user'));
    }
};
