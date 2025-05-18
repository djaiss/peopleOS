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
        Schema::create('special_dates', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('person_id');
            $table->boolean('should_be_reminded')->default(false);
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('day')->nullable();
            $table->text('name');
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
        });

        Schema::table('persons', function (Blueprint $table): void {
            $table->unsignedBigInteger('how_we_met_special_date_id')->nullable()->after('how_we_met_first_impressions');
            $table->foreign('how_we_met_special_date_id')->references('id')->on('special_dates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_dates');

        Schema::table('persons', function (Blueprint $table): void {
            $table->dropForeign(['how_we_met_special_date_id']);
            $table->dropColumn('how_we_met_special_date_id');
        });
    }
};
