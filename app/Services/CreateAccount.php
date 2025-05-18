<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserStatus;
use App\Jobs\LogUserAction;
use App\Jobs\SetupAccount;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

/**
 * Create an account for a user.
 */
class CreateAccount
{
    private Account $account;

    private User $user;

    public function __construct(
        public string $email,
        public string $password,
        public string $firstName,
        public string $lastName,
    ) {}

    public function execute(): User
    {
        $this->create();
        $this->addFirstUser();
        $this->populateAccount();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->user;
    }

    private function create(): void
    {
        $this->account = Account::create([
            'trial_ends_at' => now()->addDays(30),
        ]);
    }

    private function addFirstUser(): void
    {
        $this->user = User::create([
            'account_id' => $this->account->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'locale' => App::getLocale(),
            'status' => UserStatus::ACTIVE->value,
            'timezone' => 'UTC',
        ]);
    }

    private function populateAccount(): void
    {
        SetupAccount::dispatch($this->user)->onQueue('high');
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user)->onQueue('low');
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'account_creation',
            description: 'Created an account',
        )->onQueue('low');
    }
}
