<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table): void {
            $table->boolean('create_task_on_reminder')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table): void {
            $table->dropColumn('create_task_on_reminder');
        });
    }
};
