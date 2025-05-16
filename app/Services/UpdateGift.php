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

class UpdateGift
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly Gift $gift,
        private readonly string $status,
        private readonly ?string $name = null,
        private readonly ?string $occasion = null,
        private readonly ?string $url = null,
        private readonly ?string $giftedAt = null,
    ) {}

    public function execute(): Gift
    {
        $this->validate();
        $this->update();
        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->gift;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->gift->account_id) {
            throw new ModelNotFoundException();
        }

        if ($this->person->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }

        if ($this->gift->person_id !== $this->person->id) {
            throw new ModelNotFoundException('Gift is not associated with the person');
        }
    }

    private function update(): void
    {
        $this->gift->update([
            'status' => $this->status,
            'name' => $this->name ?? $this->gift->name,
            'occasion' => $this->occasion,
            'url' => $this->url,
            'gifted_at' => $this->giftedAt !== null && $this->giftedAt !== '' && $this->giftedAt !== '0' ? Carbon::parse($this->giftedAt) : null,
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
            action: 'gift_update',
            description: 'Updated a gift for '.$this->person->name,
        )->onQueue('low');
    }
}
