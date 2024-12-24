<?php

namespace App\Services;

use App\Models\Gender;
use App\Models\User;

class CreateGender
{
    private Gender $gender;

    public function __construct(
        public User $user,
        public string $label,
    ) {
    }

    public function execute(): Gender
    {
        $this->create();
        $this->setPosition();

        return $this->gender;
    }

    private function create(): void
    {
        $this->gender = Gender::create([
            'account_id' => $this->user->account_id,
            'label' => $this->label,
        ]);
    }

    private function setPosition(): void
    {
        $maxPosition = Gender::where('account_id', $this->user->account_id)
            ->max('position');

        $this->gender->position = $maxPosition + 1;
        $this->gender->save();
    }
}
