<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
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
        $this->createEthnicities();
    }

    private function createGenders(): void
    {
        DB::table('genders')->insert([
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Male'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Female'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Other'),
            ],
        ]);
    }

    private function createEthnicities(): void
    {
        DB::table('ethnicities')->insert([
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Americas - European Descent'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Americas - African American'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Sub-Saharan African'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('North African'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('West African'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('East African'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('East Asian'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Southeast Asian'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('South Asian'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Central Asian'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Western European'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Eastern European'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Northern European'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Southern European'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Jewish'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Arab'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Latino'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Caribbean'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Indigenous Peoples'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Polynesian'),
            ],
            [
                'account_id' => $this->user->account_id,
                'label_translation_key' => trans_key('Indigenous Peoples'),
            ],
        ]);
    }
}
