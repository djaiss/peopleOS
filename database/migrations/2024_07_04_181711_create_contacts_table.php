<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vault_id');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('maiden_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('prefix')->nullable();
            $table->boolean('can_be_deleted')->default(true);
            $table->datetime('last_updated_at')->nullable();
            $table->timestamps();
            $table->foreign('vault_id')->references('id')->on('vaults')->onDelete('cascade');
        });

        Schema::create('user_vault', function (Blueprint $table) {
            $table->unsignedBigInteger('vault_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('contact_id');
            $table->integer('permission');
            $table->timestamps();
            $table->foreign('vault_id')->references('id')->on('vaults')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user_vault');
        Schema::dropIfExists('contacts');
    }
};
