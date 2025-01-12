<?php

declare(strict_types=1);

namespace App\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidDateException;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Auth\Events\Registered;
use InvalidArgumentException;

class UpdateUserInformation
{
    public function __construct(
        public User $user,
        public string $email,
        public string $firstName,
        public string $lastName,
        public ?string $nickname,
        public ?string $bornedAt,
    ) {}

    /**
     * Update the user information.
     * If the email has changed, we need to send a new verification email to
     * verify the new email address.
     */
    public function execute(): User
    {
        $this->validate();
        $this->triggerEmailVerification();
        $this->update();
        $this->updateUserLastActivityDate();
        $this->log();

        return $this->user;
    }

    private function validate(): void
    {
        if ($this->bornedAt !== null) {
            try {
                $bornedAt = Carbon::createFromFormat('m/d/Y', $this->bornedAt);

                if ($bornedAt->isFuture()) {
                    throw new InvalidArgumentException('Birth date cannot be in the future');
                }
            } catch (InvalidFormatException) {
                throw new InvalidArgumentException('Birth date must be in MM/DD/YYYY format');
            } catch (InvalidDateException) {
                throw new InvalidArgumentException('Invalid birth date');
            }
        }
    }

    private function triggerEmailVerification(): void
    {
        if ($this->user->email !== $this->email) {
            $this->user->email_verified_at = null;
            event(new Registered($this->user));
        }
    }

    private function update(): void
    {
        $this->user->update([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'nickname' => $this->nickname,
            'borned_at' => $this->bornedAt,
        ]);
    }

    private function updateUserLastActivityDate(): void
    {
        UpdateUserLastActivityDate::dispatch($this->user);
    }

    private function log(): void
    {
        LogUserAction::dispatch(
            user: $this->user,
            action: 'personal_profile_update',
            description: 'Updated their personal profile',
        );
    }
}
