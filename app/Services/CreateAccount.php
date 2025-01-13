<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Permission;
use App\Enums\UserStatus;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Create an account.
     */
    public function execute(): User
    {
        $this->account = Account::create();

        $this->addFirstUser();
        $this->updateUserLastActivityDate();
        $this->logUserAction();

        return $this->user;
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
            'permission' => Permission::ADMINISTRATOR->value,
            'status' => UserStatus::ACTIVE->value,
            'timezone' => 'UTC',
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function logUserAction(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'account_creation',
            description: 'Created an account',
        );
    }
}
