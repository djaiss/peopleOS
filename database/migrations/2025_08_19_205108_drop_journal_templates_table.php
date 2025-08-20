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
        Schema::table('journals', function (Blueprint $table): void {
            $table->dropForeign(['journal_template_id']);
            $table->dropColumn('journal_template_id');
        });

        Schema::dropIfExists('journal_templates');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('journal_templates', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->text('name');
            $table->text('content');
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });

        Schema::table('journals', function (Blueprint $table): void {
            $table->unsignedBigInteger('journal_template_id')->nullable()->after('account_id');
            $table->foreign('journal_template_id')->references('id')->on('journal_templates')->onDelete('set null');
        });
    }
};
