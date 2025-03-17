<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'gender_id',
        'how_we_met_special_date_id',
        'marital_status',
        'kids_status',
        'slug',
        'first_name',
        'middle_name',
        'last_name',
        'nickname',
        'maiden_name',
        'suffix',
        'prefix',
        'profile_photo_path',
        'encounters_shown',
        'how_we_met_shown',
        'how_we_met',
        'how_we_met_location',
        'how_we_met_first_impressions',
        'can_be_deleted',
        'is_listed',
        'timezone',
        'nationalities',
        'languages',
        'color',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'slug' => 'encrypted',
            'marital_status' => 'encrypted',
            'kids_status' => 'encrypted',
            'first_name' => 'encrypted',
            'middle_name' => 'encrypted',
            'last_name' => 'encrypted',
            'nickname' => 'encrypted',
            'maiden_name' => 'encrypted',
            'suffix' => 'encrypted',
            'prefix' => 'encrypted',
            'encounters_shown' => 'boolean',
            'how_we_met_shown' => 'boolean',
            'how_we_met' => 'encrypted',
            'how_we_met_location' => 'encrypted',
            'how_we_met_first_impressions' => 'encrypted',
            'can_be_deleted' => 'boolean',
            'is_listed' => 'boolean',
            'timezone' => 'encrypted',
            'nationalities' => 'encrypted',
            'languages' => 'encrypted',
        ];
    }

    /**
     * Get the account associated with the person.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the gender associated with the person.
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * Get the notes associated with the person.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the work histories associated with the person.
     * (I know it's not the best name)
     */
    public function workHistories(): HasMany
    {
        return $this->hasMany(WorkHistory::class);
    }

    /**
     * Get the love relationships associated with the person.
     * This includes relationships where the person is either
     * the main person or the related person.
     */
    public function loveRelationships(): HasMany
    {
        return $this->hasMany(LoveRelationship::class, 'person_id');
    }

    /**
     * Get the special dates associated with the person.
     */
    public function specialDates(): HasMany
    {
        return $this->hasMany(SpecialDate::class);
    }

    /**
     * Get the special date associated with the How I Met occasion with this
     * person.
     */
    public function howWeMetSpecialDate(): BelongsTo
    {
        return $this->belongsTo(SpecialDate::class, 'how_we_met_special_date_id');
    }

    /**
     * Get the encounters associated with person.
     */
    public function encounters(): HasMany
    {
        return $this->hasMany(Encounter::class);
    }

    /**
     * Get the person's full name.
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

    /**
     * Get the person's current time, based on their timezone.
     */
    protected function currentTime(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): string => now($this->timezone)->format('g:i a')
        );
    }

    /**
     * Check if the person has an active love relationship.
     */
    public function hasActiveLoveRelationship(): bool
    {
        return $this->loveRelationships()
            ->where('is_current', true)
            ->exists();
    }

    /**
     * Get the person's job title, if they have an active job.
     */
    public function job(): ?string
    {
        return $this->workHistories()
            ->where('active', true)
            ->first()?->job_title;
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

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=333333&background='.$this->color.'&size='.$size;
    }
}
