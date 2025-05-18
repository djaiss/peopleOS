<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

/**
 * Class Account
 *
 * @property int $id
 * @property bool $has_lifetime_access
 * @property Carbon|null $trial_ends_at
 * @property bool $auto_delete_account
 * @property bool $create_task_on_reminder
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class Account extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'has_lifetime_access',
        'trial_ends_at',
        'auto_delete_account',
        'create_task_on_reminder',
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
            'auto_delete_account' => 'boolean',
            'create_task_on_reminder' => 'boolean',
        ];
    }

    /**
     * Get the logs associated with the account.
     *
     * @return HasMany<Log, $this>
     */
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Get the users associated with the account.
     *
     * @return HasMany<User, $this>
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the genders associated with the account.
     *
     * @return HasMany<Gender, $this>
     */
    public function genders(): HasMany
    {
        return $this->hasMany(Gender::class);
    }

    /**
     * Get the persons associated with the account.
     *
     * @return HasMany<Person, $this>
     */
    public function persons(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    /**
     * Get the encounters associated with the account.
     *
     * @return HasMany<Encounter, $this>
     */
    public function encounters(): HasMany
    {
        return $this->hasMany(Encounter::class);
    }

    /**
     * Get the task categories associated with the account.
     *
     * @return HasMany<TaskCategory, $this>
     */
    public function taskCategories(): HasMany
    {
        return $this->hasMany(TaskCategory::class);
    }

    /**
     * Get the tasks associated with the account.
     *
     * @return HasMany<Task, $this>
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the journal templates associated with the account.
     *
     * @return HasMany<JournalTemplate, $this>
     */
    public function journalTemplates(): HasMany
    {
        return $this->hasMany(JournalTemplate::class);
    }

    /**
     * Get the lifeEvents associated with the account.
     *
     * @return HasMany<LifeEvent, $this>
     */
    public function lifeEvents(): HasMany
    {
        return $this->hasMany(LifeEvent::class);
    }

    /**
     * Get the emailsSent associated with the account.
     *
     * @return HasMany<EmailSent, $this>
     */
    public function emailsSent(): HasMany
    {
        return $this->hasMany(EmailSent::class);
    }

    /**
     * Check if the account is in trial.
     *
     * @return bool
     */
    public function isInTrial(): bool
    {
        return config('peopleos.enable_paid_version')
            && ! $this->has_lifetime_access
            && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if the account needs to pay to continue using the app.
     *
     * @return bool
     */
    public function needsToPay(): bool
    {
        return config('peopleos.enable_paid_version')
            && ! $this->has_lifetime_access
            && $this->trial_ends_at->isPast();
    }

    /**
     * Check if the account is over the account limit.
     * By default, the account limit is 1000 persons.
     *
     * @return bool
     */
    public function isOverAccountLimit(): bool
    {
        return $this->persons()->count() > config('peopleos.account_limit');
    }
}
