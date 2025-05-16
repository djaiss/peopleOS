<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\LifeEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateLifeEvent
{
    public function __construct(
        public User $user,
        public LifeEvent $lifeEvent,
        public string $description,
        public string $happenedAt,
        public ?string $comment = null,
        public ?string $icon = null,
        public ?string $bgColor = null,
        public ?string $textColor = null,
        public bool $shouldBeReminded = false,
    ) {}

    public function execute(): LifeEvent
    {
        $this->validate();
        $this->update();

        if ($this->lifeEvent->specialDate()->exists()) {
            $this->lifeEvent->specialDate->delete();
        }

        if ($this->shouldBeReminded) {
            $this->updateSpecialDate();
        }

        $this->updatePersonLastConsultedDate();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->lifeEvent;
    }

    private function validate(): void
    {
        if ($this->lifeEvent->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function update(): void
    {
        $this->lifeEvent->update([
            'description' => $this->description,
            'comment' => $this->comment ?? null,
            'icon' => $this->icon ?? null,
            'bg_color' => $this->bgColor ?? null,
            'text_color' => $this->textColor ?? null,
            'happened_at' => $this->happenedAt,
        ]);
    }

    private function updateSpecialDate(): void
    {
        $happenedAt = Carbon::parse($this->happenedAt);

        $specialDate = (new CreateSpecialDate(
            user: $this->user,
            person: $this->lifeEvent->person,
            name: $this->description,
            year: $happenedAt->year ?? null,
            month: $happenedAt->month ?? null,
            day: $happenedAt->day ?? null,
            shouldBeReminded: $this->shouldBeReminded,
        ))->execute();

        $this->lifeEvent->special_date_id = $specialDate->id;
        $this->lifeEvent->save();
    }

    private function updatePersonLastConsultedDate(): void
    {
        UpdatePersonLastConsultedDate::dispatch($this->lifeEvent->person)->onQueue('low');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'life_event_update',
            description: 'Updated a life event for '.$this->lifeEvent->person->name,
        )->onQueue('low');
    }
}
