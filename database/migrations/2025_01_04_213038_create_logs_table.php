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
        Schema::create('logs', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name');
            $table->string('action');
            $table->string('description');
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
