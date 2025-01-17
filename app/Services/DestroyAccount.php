<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DestroyAccount
{
    public function __construct(
        private readonly User $user,
    ) {}

    public function execute(): void
    {
        $this->user->account->delete();
    }
}
