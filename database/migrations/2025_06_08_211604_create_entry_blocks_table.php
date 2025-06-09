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
        Schema::create('entries_blocks', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('entry_id');
            $table->morphs('blockable');
            $table->integer('position')->default(1);
            $table->timestamps();
            $table->foreign('entry_id')->references('id')->on('entries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries_blocks');
    }
};
