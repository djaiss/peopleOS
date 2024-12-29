<?php

namespace App\Services;

use App\Models\Ethnicity;
use App\Models\User;

class CreateEthnicity
{
    private Ethnicity $ethnicity;

    public function __construct(
        public User $user,
        public string $label,
    ) {}

    public function execute(): Ethnicity
    {
        $this->create();

        return $this->ethnicity;
    }

    private function create(): void
    {
        $this->ethnicity = Ethnicity::create([
            'account_id' => $this->user->account_id,
            'label' => $this->label,
        ]);
    }
}
