<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToMagicLinksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('magic_links', function (Blueprint $table): void {
            $table->index('available_at');
            $table->index('max_visits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magic_links', function (Blueprint $table): void {
            $table->dropIndex('magic_links_available_at_index');
            $table->dropIndex('magic_links_max_visits_index');
        });
    }
}
