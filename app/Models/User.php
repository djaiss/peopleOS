<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_id',
        'first_name',
        'last_name',
        'nickname',
        'email',
        'email_verified_at',
        'password',
        'locale',
        'permission',
        'does_display_full_names',
        'timezone',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'profile_photo_path',
        'last_activity_at',
        'status',
        'invited_at',
        'invitation_accepted_at',
        'borned_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'does_display_full_names' => 'boolean',
            'two_factor_confirmed_at' => 'datetime',
            'last_activity_at' => 'datetime',
            'invited_at' => 'datetime',
            'invitation_accepted_at' => 'datetime',
            'borned_at' => 'date',
        ];
    }

    /**
     * Get the account record associated with the user.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the teams associated with the user.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_user');
    }

    /**
     * Get the logs associated with the user.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Get the user's full name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes): string {
                $firstName = Arr::get($attributes, 'first_name');
                $lastName = Arr::get($attributes, 'last_name');
                $separator = $firstName && $lastName ? ' ' : '';

                return $firstName.$separator.$lastName;
            }
        );
    }

    /**
     * Get the URL to the user's profile photo.
     */
    protected function profilePhotoUrl(): Attribute
    {
        return Attribute::get(fn (): string => $this->profile_photo_path
            ? Storage::disk(config('filesystems.default'))->url($this->profile_photo_path)
            : $this->defaultProfilePhotoUrl());
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     */
    protected function defaultProfilePhotoUrl(): string
    {
        // Get first letter of each word in the name and join them with spaces
        $nameArray = explode(' ', $this->name);
        $initials = [];
        foreach ($nameArray as $namePart) {
            $initials[] = mb_substr($namePart, 0, 1);
        }
        $name = mb_trim(implode(' ', $initials));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }
}
