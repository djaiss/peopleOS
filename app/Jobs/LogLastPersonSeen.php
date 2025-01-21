<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Person;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class LogLastPersonSeen implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user,
        public Person $person,
    ) {}

    public function handle(): void
    {
        $this->user->last_person_seen_id = $this->person->id;
        $this->user->save();
    }
}
