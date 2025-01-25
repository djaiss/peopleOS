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
        Schema::create('work_information', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->text('company_name')->nullable();
            $table->text('job_title')->nullable();
            $table->text('estimated_salary')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_information');
    }
};
