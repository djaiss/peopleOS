<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdatePersonPhysicalAppearance
{
    public function __construct(
        private readonly User $user,
        private readonly Person $person,
        private readonly ?string $height = null,
        private readonly ?string $weight = null,
        private readonly ?string $build = null,
        private readonly ?string $skin_tone = null,
        private readonly ?string $face_shape = null,
        private readonly ?string $eye_color = null,
        private readonly ?string $eye_shape = null,
        private readonly ?string $hair_color = null,
        private readonly ?string $hair_type = null,
        private readonly ?string $hair_length = null,
        private readonly ?string $facial_hair = null,
        private readonly ?string $scars = null,
        private readonly ?string $tatoos = null,
        private readonly ?string $piercings = null,
        private readonly ?string $distinctive_marks = null,
        private readonly ?string $glasses = null,
        private readonly ?string $dress_style = null,
        private readonly ?string $voice = null,
    ) {}

    public function execute(): Person
    {
        $this->validate();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->person;
    }

    private function validate(): void
    {
        if ($this->user->account_id !== $this->person->account_id) {
            throw new ModelNotFoundException();
        }
    }

    private function update(): void
    {
        $this->person->update([
            'height' => $this->height,
            'weight' => $this->weight,
            'build' => $this->build,
            'skin_tone' => $this->skin_tone,
            'face_shape' => $this->face_shape,
            'eye_color' => $this->eye_color,
            'eye_shape' => $this->eye_shape,
            'hair_color' => $this->hair_color,
            'hair_type' => $this->hair_type,
            'hair_length' => $this->hair_length,
            'facial_hair' => $this->facial_hair,
            'scars' => $this->scars,
            'tatoos' => $this->tatoos,
            'piercings' => $this->piercings,
            'distinctive_marks' => $this->distinctive_marks,
            'glasses' => $this->glasses,
            'dress_style' => $this->dress_style,
            'voice' => $this->voice,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'person_physical_appearance_update',
            description: 'Updated physical appearance for '.$this->person->name,
        )->onQueue('low');
    }
}
