<?php

declare(strict_types=1);

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
        Schema::table('persons', function (Blueprint $table): void {
            $table->unsignedBigInteger('age_special_date_id')->nullable()->after('how_we_met_special_date_id');
            $table->text('age_type')->nullable()->after('prefix');
            $table->text('estimated_age')->nullable()->after('age_type');
            $table->datetime('age_estimated_at')->nullable()->after('estimated_age');
            $table->text('age_bracket')->nullable()->after('age_estimated_at');
            $table->foreign('age_special_date_id')->references('id')->on('special_dates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persons', function (Blueprint $table): void {
            $table->dropForeign(['age_special_date_id']);
            $table->dropColumn('age_special_date_id');
            $table->dropColumn('age_type');
            $table->dropColumn('estimated_age');
            $table->dropColumn('age_estimated_at');
            $table->dropColumn('age_bracket');
        });
    }
};
