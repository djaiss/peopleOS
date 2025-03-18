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
        Schema::create('gifts', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('person_id');
            $table->text('status');
            $table->text('name');
            $table->text('occasion')->nullable();
            $table->text('url')->nullable();
            $table->string('image_path', 2048)->nullable();
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
        });

        Schema::table('persons', function (Blueprint $table): void {
            $table->string('gift_tab_shown')->nullable()->after('encounters_shown');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifts');

        Schema::table('persons', function (Blueprint $table): void {
            $table->dropColumn('gift_tab_shown');
        });
    }
};
