<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use Exception;

class UpdateSpecialDate
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly SpecialDate $specialDate,
        private readonly string $name,
        private readonly ?int $year,
        private readonly ?int $month,
        private readonly ?int $day,
        private readonly bool $shouldBeReminded,
    ) {}

    public function execute(): SpecialDate
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();

        return $this->specialDate;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->person->account_id) {
            throw new Exception('User and person are not in the same account');
        }

        if ($this->specialDate->person_id !== $this->person->id) {
            throw new Exception('Special date is not associated with the person');
        }
    }

    private function update(): void
    {
        $this->specialDate->update([
            'name' => $this->name,
            'year' => $this->year ?? null,
            'month' => $this->month ?? 1,
            'day' => $this->day ?? 1,
            'should_be_reminded' => $this->shouldBeReminded,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }
}
