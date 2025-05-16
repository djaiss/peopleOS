<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Person;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdatePersonLastConsultedDate implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Person $person,
    ) {}

    public function handle(): void
    {
        $this->person->last_consulted_at = now();
        $this->person->save();
    }
}
