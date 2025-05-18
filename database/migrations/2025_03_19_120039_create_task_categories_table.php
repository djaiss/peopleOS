<?php

declare(strict_types=1);

use App\Models\Account;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_categories', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->text('name');
            $table->string('color', 30);
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });

        foreach (Account::all() as $account) {
            DB::table('task_categories')->insert([
                [
                    'account_id' => $account->id,
                    'name' => Crypt::encryptString('Birthday'),
                    'color' => 'bg-purple-100',
                    'created_at' => now(),
                    'updated_at' => null,
                ],
                [
                    'account_id' => $account->id,
                    'name' => Crypt::encryptString('Call'),
                    'color' => 'bg-blue-100',
                    'created_at' => now(),
                    'updated_at' => null,
                ],
                [
                    'account_id' => $account->id,
                    'name' => Crypt::encryptString('Email'),
                    'color' => 'bg-green-100',
                    'created_at' => now(),
                    'updated_at' => null,
                ],
                [
                    'account_id' => $account->id,
                    'name' => Crypt::encryptString('Follow up'),
                    'color' => 'bg-yellow-100',
                    'created_at' => now(),
                    'updated_at' => null,
                ],
                [
                    'account_id' => $account->id,
                    'name' => Crypt::encryptString('Lunch'),
                    'color' => 'bg-orange-100',
                    'created_at' => now(),
                    'updated_at' => null,
                ],
                [
                    'account_id' => $account->id,
                    'name' => Crypt::encryptString('Thank you'),
                    'color' => 'bg-red-100',
                    'created_at' => now(),
                    'updated_at' => null,
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_categories');
    }
};
