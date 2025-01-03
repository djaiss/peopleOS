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
        Schema::create('partners', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('marital_status_id');
            $table->text('name')->nullable();
            $table->text('occupation')->nullable();
            $table->text('number_of_years_together')->nullable();
            $table->timestamps();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->foreign('marital_status_id')->references('id')->on('marital_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
