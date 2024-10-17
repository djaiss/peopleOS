<?php

namespace App\Services;

use App\Models\Gender;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateGender
{
    public function __construct(
        public User $user,
        public Gender $gender,
        public string $label,
    ) {}

    public function execute(): Gender
    {
        $this->validate();
        $this->update();

        return $this->gender;
    }

    private function validate(): void
    {
        // make sure the user's account is the same as the gender's
        if ($this->user->account_id !== $this->gender->account_id) {
            throw new ModelNotFoundException;
        }
    }

    private function update(): void
    {
        $this->gender->label = $this->label;
        $this->gender->save();
    }
}
