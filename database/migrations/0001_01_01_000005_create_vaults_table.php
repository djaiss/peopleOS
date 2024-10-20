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
        Schema::create('vaults', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('show_group_tab')->default(true);
            $table->boolean('show_tasks_tab')->default(true);
            $table->boolean('show_files_tab')->default(true);
            $table->boolean('show_journal_tab')->default(true);
            $table->boolean('show_companies_tab')->default(true);
            $table->boolean('show_reports_tab')->default(true);
            $table->boolean('show_calendar_tab')->default(true);
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaults');
    }
};
