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
        public int $position,
    ) {
    }

    public function execute(): Gender
    {
        $this->validate();
        $this->update();
        $this->updatePosition();

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

    private function updatePosition(): void
    {
        if ($this->position > $this->gender->position) {
            $this->updateAscendingPosition();
        } else {
            $this->updateDescendingPosition();
        }

        $this->gender->update([
            'position' => $this->position,
        ]);
    }

    private function updateAscendingPosition(): void
    {
        $this->gender->where('position', '>', $this->gender->position)
            ->where('position', '<=', $this->position)
            ->decrement('position');
    }

    private function updateDescendingPosition(): void
    {
        $this->gender->where('position', '>=', $this->position)
            ->where('position', '<', $this->gender->position)
            ->increment('position');
    }
}
