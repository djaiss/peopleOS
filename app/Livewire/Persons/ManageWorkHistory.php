<?php

declare(strict_types=1);

namespace App\Livewire\Persons;

use Livewire\Component;

class ManageWorkHistory extends Component
{
    public bool $addMode = false;

    public function render()
    {
        return view('livewire.persons.manage-work-history');
    }

    public function toggleAddMode(): void
    {
        $this->addMode = ! $this->addMode;
    }
}
