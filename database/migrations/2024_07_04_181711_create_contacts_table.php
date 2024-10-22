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
        Schema::create('contacts', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('vault_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('ethnicity_id')->nullable();
            $table->text('slug')->nullable();
            $table->text('first_name')->nullable();
            $table->text('middle_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('nickname')->nullable();
            $table->text('maiden_name')->nullable();
            $table->text('patronymic_name')->nullable();
            $table->text('tribal_name')->nullable();
            $table->text('generation_name')->nullable();
            $table->text('romanized_name')->nullable();
            $table->text('nationality')->nullable();
            $table->text('marital_status')->nullable();
            $table->text('suffix')->nullable();
            $table->text('prefix')->nullable();
            $table->text('background_information')->nullable();
            $table->text('job_title')->nullable();
            $table->boolean('can_be_deleted')->default(true);
            $table->timestamps();
            $table->foreign('vault_id')->references('id')->on('vaults')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('set null');
            $table->foreign('ethnicity_id')->references('id')->on('ethnicities')->onDelete('set null');
        });

        Schema::create('user_vault', function (Blueprint $table): void {
            $table->unsignedBigInteger('vault_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('contact_id');
            $table->integer('permission');
            $table->timestamps();
            $table->foreign('vault_id')->references('id')->on('vaults')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vault');
        Schema::dropIfExists('contacts');
    }
};
