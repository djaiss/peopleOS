<?php

declare(strict_types=1);

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

/**
 * Class User
 *
 * @property int $id
 * @property int $account_id
 * @property bool $is_instance_admin
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $nickname
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string $locale
 * @property bool $does_display_full_names
 * @property bool $does_display_age
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $profile_photo_path
 * @property Carbon|null $last_activity_at
 * @property string|null $status
 * @property Carbon|null $invited_at
 * @property Carbon|null $invitation_accepted_at
 * @property Carbon|null $born_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $last_person_seen_id
 * @property string|null $timezone
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
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
        'timezone',
        'email',
        'email_verified_at',
        'password',
        'locale',
        'does_display_full_names',
        'does_display_age',
        'two_factor_preferred_method',
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
            'timezone' => 'encrypted',
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
     *
     * @return BelongsTo<Account, $this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the last person seen by the user.
     *
     * @return BelongsTo<Person, $this>
     */
    public function lastPersonSeen(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'last_person_seen_id');
    }

    /**
     * Get the logs associated with the user.
     *
     * @return HasMany<Log, $this>
     */
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Get the marketing pages associated with the user.
     *
     * @return BelongsToMany<MarketingPage, $this>
     */
    public function marketingPages(): BelongsToMany
    {
        return $this->belongsToMany(
            related: MarketingPage::class,
            table: 'marketing_page_user',
            foreignPivotKey: 'user_id',
            relatedPivotKey: 'marketing_page_id',
        )
            ->using(MarketingPageUser::class)
            ->withPivot('helpful', 'comment')
            ->withTimestamps();
    }

    /**
     * Get the user's full name by combining first and last name.
     *
     * @return Attribute<string, string>
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $firstName = $this->first_name;
                $lastName = $this->last_name;
                $separator = $firstName && $lastName ? ' ' : '';

                return $firstName . $separator . $lastName;
            },
        );
    }

    /**
     * Get the user's avatar image URL with the specified size.
     *
     * @param int<1, 1024> $size The size of the avatar image in pixels
     *
     * @return string The URL of the avatar image
     */
    public function getAvatar(int $size = 64): string
    {
        return $this->profile_photo_path
            ? $this->resizedAvatar($size)
            : $this->defaultAvatar($size);
    }

    /**
     * Get the URL for the user's uploaded avatar with the specified size.
     *
     * @param int<1, 1024> $size The size of the avatar image in pixels
     *
     * @return string The URL of the resized avatar image
     */
    protected function resizedAvatar(int $size = 64): string
    {
        return ImageHelper::getImageVariantPath($this->profile_photo_path, $size);
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @param int<1, 1024> $size The size of the avatar image in pixels
     *
     * @return string The URL of the default avatar image
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

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) .
            '&color=7F9CF5&background=EBF4FF&size=' . $size;
    }
}
