<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccessCodeToMagicLinksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('magic_links', function (Blueprint $table): void {
            $table->string('access_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('magic_links', 'access_code')) {
            Schema::table('magic_links', function (Blueprint $table): void {
                $table->dropColumn('access_code');
            });
        }
    }
}
