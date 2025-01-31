<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'last_person_seen_id',
        'first_name',
        'last_name',
        'nickname',
        'email',
        'email_verified_at',
        'password',
        'locale',
        'does_display_full_names',
        'does_display_age',
        'timezone',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'profile_photo_path',
        'last_activity_at',
        'status',
        'invited_at',
        'invitation_accepted_at',
        'born_at',
        'is_instance_admin',
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
            'last_person_seen_id' => 'integer',
            'first_name' => 'encrypted',
            'last_name' => 'encrypted',
            'nickname' => 'encrypted',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'does_display_full_names' => 'boolean',
            'does_display_age' => 'boolean',
            'two_factor_confirmed_at' => 'datetime',
            'last_activity_at' => 'datetime',
            'invited_at' => 'datetime',
            'invitation_accepted_at' => 'datetime',
            'born_at' => 'date',
            'is_instance_admin' => 'boolean',
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
     * Get the last person seen by the user.
     */
    public function lastPersonSeen(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'last_person_seen_id');
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
            get: function (mixed $value, array $attributes): string {
                $firstName = $this->first_name;
                $lastName = $this->last_name;
                $separator = $firstName && $lastName ? ' ' : '';

                return $firstName.$separator.$lastName;
            }
        );
    }

    public function getAvatar(int $size = 64): string
    {
        return $this->profile_photo_path
            ? Storage::disk(config('filesystems.default'))->url($this->profile_photo_path)
            : $this->defaultAvatar($size);
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     */
    protected function defaultAvatar(int $size = 64): string
    {
        // Get first letter of each word in the name and join them with spaces
        $nameArray = explode(' ', $this->name);
        $initials = [];
        foreach ($nameArray as $namePart) {
            $initials[] = mb_substr($namePart, 0, 1);
        }
        $name = mb_trim(implode(' ', $initials));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF&size='.$size;
    }
}
