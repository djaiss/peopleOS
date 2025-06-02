<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('food_allergies');
    }

    public function down(): void
    {
        Schema::create('food_allergies', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('person_id')->nullable();
            $table->text('name');
            $table->timestamps();
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
        });
    }
};
