<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('persons', function (Blueprint $table): void {
            $table->text('timezone')->nullable()->after('prefix');
            $table->text('nationalities')->nullable()->after('timezone');
            $table->text('languages')->nullable()->after('nationalities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persons', function (Blueprint $table): void {
            $table->dropColumn('timezone');
            $table->dropColumn('nationalities');
            $table->dropColumn('languages');
        });
    }
};
