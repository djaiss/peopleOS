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
        Schema::create('persons', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->text('marital_status')->nullable();
            $table->text('kids_status')->nullable();
            $table->text('slug')->nullable();
            $table->text('first_name')->nullable();
            $table->text('middle_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('nickname')->nullable();
            $table->text('maiden_name')->nullable();
            $table->text('suffix')->nullable();
            $table->text('prefix')->nullable();
            $table->boolean('how_we_met_shown')->default(true);
            $table->text('how_we_met')->nullable();
            $table->text('how_we_met_location')->nullable();
            $table->text('how_we_met_first_impressions')->nullable();
            $table->boolean('can_be_deleted')->default(true);
            $table->boolean('is_listed')->default(true);
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('set null');
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->unsignedBigInteger('last_person_seen_id')->nullable()->after('account_id');
            $table->foreign('last_person_seen_id')->references('id')->on('persons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
