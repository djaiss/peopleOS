<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gift;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Create a gift.
 */
class CreateGift
{
    private Gift $gift;

    public function __construct(
        public User $user,
        public Person $person,
        public string $status,
        public ?string $name = null,
        public ?string $occasion = null,
        public ?string $url = null,
        public ?string $giftedAt = null,
    ) {}

    public function execute(): Gift
    {
        $this->validate();
        $this->create();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->gift;
    }

    private function validate(): void
    {
        if ($this->person->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function create(): void
    {
        $giftedAt = $this->giftedAt === null || $this->giftedAt === '' || $this->giftedAt === '0' ? null : Carbon::parse($this->giftedAt);

        $this->gift = Gift::create([
            'account_id' => $this->user->account_id,
            'person_id' => $this->person->id,
            'status' => $this->status,
            'name' => $this->name ?? null,
            'occasion' => $this->occasion ?? null,
            'url' => $this->url ?? null,
            'gifted_at' => $giftedAt,
        ]);
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->person)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'gift_creation',
            description: 'Logged a gift for ' . $this->person->name,
        )->onQueue('low');
    }
}
