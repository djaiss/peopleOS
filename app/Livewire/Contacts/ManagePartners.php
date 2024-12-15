<?php

namespace App\Livewire\Contacts;

use Livewire\Component;

class ManagePartners extends Component
{
    public bool $addMode = false;

    public function render()
    {
        return view('livewire.contacts.manage-partners');
    }
}
