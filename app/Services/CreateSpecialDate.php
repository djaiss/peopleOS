<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use Exception;

class CreateSpecialDate
{
    private SpecialDate $specialDate;

    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly string $name,
        private readonly ?int $year,
        private readonly ?int $month,
        private readonly ?int $day,
        private readonly bool $shouldBeReminded,
    ) {}

    public function execute(): SpecialDate
    {
        $this->validate();
        $this->create();
        $this->updateUserLastActivityDate();

        return $this->specialDate;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->person->account_id) {
            throw new Exception('User and person are not in the same account');
        }
    }

    private function create(): void
    {
        $this->specialDate = SpecialDate::create([
            'account_id' => $this->user->account_id,
            'person_id' => $this->person->id,
            'name' => $this->name,
            'year' => $this->year ?? null,
            'month' => $this->month ?? null,
            'day' => $this->day ?? null,
            'should_be_reminded' => $this->shouldBeReminded,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }
}
