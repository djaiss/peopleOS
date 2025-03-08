<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class SetupAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->createGenders();
    }

    private function createGenders(): void
    {
        DB::table('genders')->insert([
            [
                'account_id' => $this->user->account_id,
                'position' => 1,
                'name' => Crypt::encryptString('Man'),
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 2,
                'name' => Crypt::encryptString('Woman'),
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 3,
                'name' => Crypt::encryptString('Other'),
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);
    }
}
