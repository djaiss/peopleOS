<?php

namespace App\Services;

use App\Cache\AccountVaultsCache;
use App\Models\Template;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyTemplate
{
    public function __construct(
        public User $user,
        public Template $template,
    ) {
    }

    public function execute(): void
    {
        $this->validate();
        $this->template->delete();
    }

    public function validate(): void
    {
        if ($this->template->account_id !== $this->user->account_id) {
            throw new ModelNotFoundException;
        }
    }
}
