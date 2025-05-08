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
        Schema::table('user_waitlist', function (Blueprint $table): void {
            $table->text('status')->nullable()->after('confirmation_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_waitlist', function (Blueprint $table): void {
            $table->dropColumn('status');
        });
    }
};
