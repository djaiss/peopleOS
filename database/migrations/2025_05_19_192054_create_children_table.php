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
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('second_parent_id')->nullable();
            $table->unsignedBigInteger('age_special_date_id')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->text('first_name');
            $table->text('last_name')->nullable();
            $table->text('age_type')->nullable();
            $table->text('estimated_age')->nullable();
            $table->datetime('age_estimated_at')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_born')->default(true);
            $table->datetime('expected_birth_date_at')->nullable();
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('persons')->onDelete('set null');
            $table->foreign('second_parent_id')->references('id')->on('persons')->onDelete('set null');
            $table->foreign('age_special_date_id')->references('id')->on('special_dates')->onDelete('set null');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
