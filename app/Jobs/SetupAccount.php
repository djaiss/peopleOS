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
        //$this->createEthnicities();
        //$this->createMaritalStatuses();
    }

    private function createGenders(): void
    {
        DB::table('genders')->insert([
            [
                'account_id' => $this->user->account_id,
                'position' => 1,
                'name' =>  'Man',
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 2,
                'name' =>  'Woman',
            ],
            [
                'account_id' => $this->user->account_id,
                'position' => 3,
                'name' =>  'Other',
            ],
        ]);
    }

    // private function createEthnicities(): void
    // {
    //     DB::table('ethnicities')->insert([
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Americas - European Descent'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Americas - African American'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Sub-Saharan African'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('North African'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('West African'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('East African'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('East Asian'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Southeast Asian'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('South Asian'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Central Asian'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Western European'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Eastern European'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Northern European'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Southern European'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Jewish'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Arab'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Latino'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Caribbean'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Indigenous Peoples'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Polynesian'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Indigenous Peoples'),
    //             'created_at' => now(),
    //         ],
    //     ]);
    // }

    // private function createMaritalStatuses(): void
    // {
    //     DB::table('marital_statuses')->insert([
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Single'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Married'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Divorced'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Civil Union'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Widowed'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Separated'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Cohabiting'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Engaged'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('In a Relationship'),
    //             'created_at' => now(),
    //         ],
    //         [
    //             'account_id' => $this->user->account_id,
    //             'label_translation_key' => trans_key('Complicated'),
    //             'created_at' => now(),
    //         ],
    //     ]);
    // }
}
