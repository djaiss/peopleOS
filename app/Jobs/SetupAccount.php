<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\MaritalStatusType;
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
        $this->createMaritalStatuses();
    }

    private function createGenders(): void
    {
        DB::table('genders')->insert([
            [
                'account_id' => $this->user->account_id,
                'position' => 1,
                'name' => Crypt::encryptString('Man'),
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 2,
                'name' => Crypt::encryptString('Woman'),
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 3,
                'name' => Crypt::encryptString('Other'),
            ],
        ]);
    }

    private function createMaritalStatuses(): void
    {
        DB::table('marital_statuses')->insert([
            [
                'account_id' => $this->user->account_id,
                'position' => 1,
                'name' => Crypt::encryptString('Unknown'),
                'can_be_deleted' => false,
                'type' => MaritalStatusType::UNKNOWN->value,
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 2,
                'name' => Crypt::encryptString('Single'),
                'can_be_deleted' => true,
                'type' => MaritalStatusType::SINGLE->value,
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 3,
                'name' => Crypt::encryptString('In a relationship'),
                'can_be_deleted' => true,
                'type' => MaritalStatusType::COUPLE->value,
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 4,
                'name' => Crypt::encryptString('Married'),
                'can_be_deleted' => true,
                'type' => MaritalStatusType::COUPLE->value,
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 5,
                'name' => Crypt::encryptString('Divorced'),
                'can_be_deleted' => true,
                'type' => MaritalStatusType::COUPLE->value,
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 6,
                'name' => Crypt::encryptString('Civil union'),
                'can_be_deleted' => true,
                'type' => MaritalStatusType::COUPLE->value,
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 7,
                'name' => Crypt::encryptString('Widowed'),
                'can_be_deleted' => true,
                'type' => MaritalStatusType::COUPLE->value,
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 8,
                'name' => Crypt::encryptString('Separated'),
                'can_be_deleted' => true,
                'type' => MaritalStatusType::COUPLE->value,
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 9,
                'name' => Crypt::encryptString('Cohabiting'),
                'can_be_deleted' => true,
                'type' => MaritalStatusType::COUPLE->value,
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 10,
                'name' => Crypt::encryptString('Engaged'),
                'can_be_deleted' => true,
                'type' => MaritalStatusType::COUPLE->value,
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 11,
                'name' => Crypt::encryptString('Complicated'),
                'can_be_deleted' => true,
                'type' => MaritalStatusType::COUPLE->value,
            ],
        ]);
    }
}
