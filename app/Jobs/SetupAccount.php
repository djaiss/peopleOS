<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\JournalTemplate;
use App\Models\User;
use App\Services\CreateJournal;
use App\Services\CreateJournalTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class SetupAccount implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private JournalTemplate $journalTemplate;

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
        $this->createTaskCategories();
        $this->createJournalTemplate();
        $this->createJournal();
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

    private function createTaskCategories(): void
    {
        DB::table('task_categories')->insert([
            [
                'account_id' => $this->user->account_id,
                'name' => Crypt::encryptString('Birthday'),
                'color' => 'bg-purple-100',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'account_id' => $this->user->account_id,
                'name' => Crypt::encryptString('Call'),
                'color' => 'bg-blue-100',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'account_id' => $this->user->account_id,
                'name' => Crypt::encryptString('Email'),
                'color' => 'bg-green-100',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'account_id' => $this->user->account_id,
                'name' => Crypt::encryptString('Follow up'),
                'color' => 'bg-yellow-100',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'account_id' => $this->user->account_id,
                'name' => Crypt::encryptString('Lunch'),
                'color' => 'bg-orange-100',
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'account_id' => $this->user->account_id,
                'name' => Crypt::encryptString('Thank you'),
                'color' => 'bg-red-100',
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);
    }

    private function createJournalTemplate(): void
    {
        $template = <<<'YAML'
template:
  name: "Daily Reflection"
  columns:
    - name: "Morning"
      questions:
        - name: "Sleep quality"
          answers:
            type: "range"
            range: [1, 5]
            comment_allowed: true
    - name: "Afternoon"
      questions:
        - name: "Productivity"
          answers:
            type: "choice"
            options: ["High", "Medium", "Low"]
            comment_allowed: false
YAML;

        $this->journalTemplate = (new CreateJournalTemplate(
            user: $this->user,
            name: 'My first template',
            content: $template,
        ))->execute();
    }

    private function createJournal(): void
    {
        (new CreateJournal(
            user: $this->user,
            journalTemplate: $this->journalTemplate,
            name: 'My first journal',
        ))->execute();
    }
}
