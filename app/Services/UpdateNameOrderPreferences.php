<?php

namespace App\Services;

use App\Models\User;

class UpdateNameOrderPreferences
{
    public function __construct(
        public User $user,
        public string $nameOrder,
    ) {}

    public function execute(): User
    {
        $this->checkNameOrderValidity();
        $this->updateUser();

        return $this->user;
    }

    private function checkNameOrderValidity(): void
    {
        // there should be at least one variable in the name order
        if (substr_count($this->nameOrder, '%') < 1) {
            throw new \Exception('The name order must contain at least one variable.');
        }

        if (substr_count($this->nameOrder, '%') % 2 == 1) {
            throw new \Exception('At least one % is missing to have a valid name order.');
        }
    }

    private function updateUser(): void
    {
        $this->user->name_order = $this->nameOrder;
        $this->user->save();
    }
}
