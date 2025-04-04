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
        Schema::table('marketing_pages', function (Blueprint $table): void {
            $table->datetime('written_at')->nullable()->after('marked_not_helpful');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marketing_pages', function (Blueprint $table): void {
            $table->dropColumn('written_at');
        });
    }
};
