<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Cache\PeopleListCache;
use App\Models\Person;
use App\Services\ResizeImage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ResizePersonAvatar implements ShouldQueue
{
    use Queueable;

    private bool $valid = true;

    public function __construct(
        public Person $person
    ) {}

    /**
     * Create different sizes of the person's avatar.
     */
    public function handle(): void
    {
        $this->validate();

        if (! $this->valid) {
            return;
        }

        (new ResizeImage(
            path: $this->person->profile_photo_path,
            maxWidth: 64,
            maxHeight: 64,
        ))->execute();

        (new ResizeImage(
            path: $this->person->profile_photo_path,
            maxWidth: 40,
            maxHeight: 40,
        ))->execute();

        $this->refreshCache();
    }

    private function validate(): void
    {
        Log::info('Resizing person avatar', ['person' => $this->person->id]);

        try {
            $this->person = Person::where('id', $this->person->id)->firstOrFail();
        } catch (ModelNotFoundException) {
            Log::error('Person not found', ['person' => $this->person->id]);
            $this->valid = false;
        }
    }

    private function refreshCache(): void
    {
        PeopleListCache::make(
            accountId: $this->person->account_id,
        )->refresh();
    }
}
