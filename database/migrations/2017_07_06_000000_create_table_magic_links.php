<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMagicLinks extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('magiclink.magiclink_table', 'magic_links'), function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('token', 255);
            $table->text('action');
            $table->unsignedTinyInteger('num_visits')->default(0);
            $table->unsignedTinyInteger('max_visits')->nullable();
            $table->timestamp('available_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('magiclink.magiclink_table', 'magic_links'));
    }
}
