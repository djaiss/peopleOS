<?php

namespace App\Models;

use App\Helpers\AvatarHelper;
use App\Helpers\NameHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    /**
     * Possible avatar types.
     */
    public const AVATAR_TYPE_SVG = 'svg';

    public const AVATAR_TYPE_URL = 'url';

    /**
     * Possible genders.
     */
    public const GENDER_MALE = 'male';

    public const GENDER_FEMALE = 'female';

    public const GENDER_OTHER = 'other';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'vault_id',
        'company_id',
        'gender_id',
        'slug',
        'first_name',
        'middle_name',
        'last_name',
        'nickname',
        'maiden_name',
        'suffix',
        'prefix',
        'background_information',
        'job_title',
        'can_be_deleted',
        'last_updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'can_be_deleted' => 'boolean',
        'last_updated_at' => 'datetime',
        'slug' => 'encrypted',
        'first_name' => 'encrypted',
        'middle_name' => 'encrypted',
        'last_name' => 'encrypted',
        'nickname' => 'encrypted',
        'maiden_name' => 'encrypted',
        'suffix' => 'encrypted',
        'prefix' => 'encrypted',
        'background_information' => 'encrypted',
        'job_title' => 'encrypted',
    ];

    /**
     * Get the vault associated with the contact.
     */
    public function vault(): BelongsTo
    {
        return $this->belongsTo(Vault::class);
    }

    /**
     * Get the company associated with the contact.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the gender associated with the contact.
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * Get the note records associated with the contact.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the child records associated with the contact.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Child::class);
    }

    /**
     * Get the name of the contact, according to the user preference.
     *
     * @return Attribute<string,never>
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (Auth::check()) {
                    return NameHelper::formatContactName(Auth::user(), $this);
                }

                $firstName = Arr::get($attributes, 'first_name');
                $lastName = Arr::get($attributes, 'last_name');
                $separator = $firstName && $lastName ? ' ' : '';

                return $firstName.$separator.$lastName;
            }
        );
    }

    /**
     * Get the avatar of the contact.
     *
     * @return Attribute<array,never>
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $type = self::AVATAR_TYPE_SVG;
                $content = AvatarHelper::generateRandomAvatar($this);

                return [
                    'type' => $type,
                    'content' => $content,
                ];
            }
        );
    }
}
