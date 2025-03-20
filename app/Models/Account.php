<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'has_lifetime_access',
        'trial_ends_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'has_lifetime_access' => 'boolean',
            'trial_ends_at' => 'datetime',
        ];
    }

    /**
     * Get the logs associated with the account.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Get the users associated with the account.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the genders associated with the account.
     */
    public function genders(): HasMany
    {
        return $this->hasMany(Gender::class);
    }

    /**
     * Get the persons associated with the account.
     */
    public function persons(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    /**
     * Get the encounters associated with the account.
     */
    public function encounters(): HasMany
    {
        return $this->hasMany(Encounter::class);
    }

    /**
     * Get the task categories associated with the account.
     */
    public function taskCategories(): HasMany
    {
        return $this->hasMany(TaskCategory::class);
    }

    /**
     * Get the tasks associated with the account.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Check if the account is in trial.
     */
    public function isInTrial(): bool
    {
        return config('peopleos.enable_paid_version')
            && ! $this->has_lifetime_access
            && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if the account needs to pay to continue using the app.
     */
    public function needsToPay(): bool
    {
        return config('peopleos.enable_paid_version')
            && ! $this->has_lifetime_access
            && $this->trial_ends_at->isPast();
    }
}
