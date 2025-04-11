<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\LifeEvent;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CreateLifeEvent
{
    private LifeEvent $lifeEvent;

    public function __construct(
        public User $user,
        public Person $person,
        public string $description,
        public string $happensAt,
        public ?string $comment = null,
        public ?string $icon = null,
        public ?string $bgColor = null,
        public ?string $textColor = null,
        public bool $shouldBeReminded = false,
    ) {}

    public function execute(): LifeEvent
    {
        $this->validate();
        $this->create();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->lifeEvent;
    }

    private function validate(): void
    {
        if ($this->person->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function create(): void
    {
        $this->lifeEvent = LifeEvent::create([
            'account_id' => $this->user->account_id,
            'person_id' => $this->person->id,
            'description' => $this->description,
            'comment' => $this->comment ?? null,
            'icon' => $this->icon ?? null,
            'bg_color' => $this->bgColor ?? null,
            'text_color' => $this->textColor ?? null,
        ]);

        if ($this->happensAt !== '' && $this->happensAt !== '0') {
            $happensAt = Carbon::parse($this->happensAt);

            $specialDate = (new CreateSpecialDate(
                user: $this->user,
                person: $this->person,
                name: $this->description,
                year: $happensAt->year ?? null,
                month: $happensAt->month ?? null,
                day: $happensAt->day ?? null,
                shouldBeReminded: $this->shouldBeReminded,
            ))->execute();

            $this->lifeEvent->special_date_id = $specialDate->id;
            $this->lifeEvent->save();
        }
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'life_event_creation',
            description: 'Logged a life event for '.$this->person->name,
        )->onQueue('low');
    }
}
