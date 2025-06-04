<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AgeType;
use App\Enums\KidsStatusType;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class Person extends Model
{
    /**
     * Class Person
     *
     * @property int $id
     * @property int $account_id
     * @property int|null $gender_id
     * @property int|null $how_we_met_special_date_id
     * @property int|null $age_special_date_id
     * @property string|null $marital_status
     * @property string|null $kids_status
     * @property string|null $slug
     * @property string|null $first_name
     * @property string|null $middle_name
     * @property string|null $last_name
     * @property string|null $nickname
     * @property string|null $maiden_name
     * @property string|null $suffix
     * @property string|null $prefix
     * @property string|null $profile_photo_path
     * @property bool $encounters_shown
     * @property bool $how_we_met_shown
     * @property string|null $how_we_met
     * @property string|null $how_we_met_location
     * @property string|null $how_we_met_first_impressions
     * @property bool $can_be_deleted
     * @property bool $is_listed
     * @property string|null $timezone
     * @property string|null $nationalities
     * @property string|null $languages
     * @property string|null $color
     * @property string|null $height
     * @property string|null $weight
     * @property string|null $build
     * @property string|null $skin_tone
     * @property string|null $face_shape
     * @property string|null $eye_color
     * @property string|null $eye_shape
     * @property string|null $hair_color
     * @property string|null $hair_type
     * @property string|null $hair_length
     * @property string|null $facial_hair
     * @property string|null $scars
     * @property string|null $tatoos
     * @property string|null $piercings
     * @property string|null $distinctive_marks
     * @property string|null $glasses
     * @property string|null $dress_style
     * @property string|null $voice
     * @property string|null $gift_tab_shown
     * @property string|null $age_type
     * @property string|null $estimated_age
     * @property string|null $age_bracket
     * @property Carbon|null $age_estimated_at
     * @property bool $show_past_love_relationships
     * @property Carbon|null $last_consulted_at
     * @property string|null $food_allergies
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
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
        'age_special_date_id',
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
        'height',
        'weight',
        'build',
        'skin_tone',
        'face_shape',
        'eye_color',
        'eye_shape',
        'hair_color',
        'hair_type',
        'hair_length',
        'facial_hair',
        'scars',
        'tatoos',
        'piercings',
        'distinctive_marks',
        'glasses',
        'dress_style',
        'voice',
        'gift_tab_shown',
        'age_type',
        'estimated_age',
        'age_bracket',
        'age_estimated_at',
        'show_past_love_relationships',
        'last_consulted_at',
        'food_allergies',
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
            'age_type' => 'encrypted',
            'estimated_age' => 'encrypted',
            'age_bracket' => 'encrypted',
            'age_estimated_at' => 'datetime',
            'height' => 'encrypted',
            'weight' => 'encrypted',
            'build' => 'encrypted',
            'skin_tone' => 'encrypted',
            'face_shape' => 'encrypted',
            'eye_color' => 'encrypted',
            'eye_shape' => 'encrypted',
            'hair_color' => 'encrypted',
            'hair_type' => 'encrypted',
            'hair_length' => 'encrypted',
            'facial_hair' => 'encrypted',
            'scars' => 'encrypted',
            'tatoos' => 'encrypted',
            'piercings' => 'encrypted',
            'distinctive_marks' => 'encrypted',
            'glasses' => 'encrypted',
            'dress_style' => 'encrypted',
            'voice' => 'encrypted',
            'show_past_love_relationships' => 'boolean',
            'last_consulted_at' => 'datetime',
            'food_allergies' => 'encrypted',
        ];
    }

    /**
     * Get the account associated with the person.
     *
     * @return BelongsTo<Account, $this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the gender associated with the person.
     *
     * @return BelongsTo<Gender, $this>
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * Get the notes associated with the person.
     *
     * @return HasMany<Note, $this>
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the work histories associated with the person.
     *
     * @return HasMany<WorkHistory, $this>
     */
    public function workHistories(): HasMany
    {
        return $this->hasMany(WorkHistory::class);
    }

    /**
     * Get the love relationships associated with the person.
     * This includes relationships where the person is either
     * the main person or the related person.
     *
     * @return HasMany<LoveRelationship, $this>
     */
    public function loveRelationships(): HasMany
    {
        return $this->hasMany(LoveRelationship::class, 'person_id');
    }

    /**
     * Get the special dates associated with the person.
     *
     * @return HasMany<SpecialDate, $this>
     */
    public function specialDates(): HasMany
    {
        return $this->hasMany(SpecialDate::class);
    }

    /**
     * Get the special date associated with how the person was met.
     *
     * @return BelongsTo<SpecialDate, $this>
     */
    public function howWeMetSpecialDate(): BelongsTo
    {
        return $this->belongsTo(SpecialDate::class, 'how_we_met_special_date_id');
    }

    /**
     * Get the special date associated with the person's age.
     *
     * @return BelongsTo<SpecialDate, $this>
     */
    public function ageSpecialDate(): BelongsTo
    {
        return $this->belongsTo(SpecialDate::class, 'age_special_date_id');
    }

    /**
     * Get the encounters associated with the person.
     *
     * @return HasMany<Encounter, $this>
     */
    public function encounters(): HasMany
    {
        return $this->hasMany(Encounter::class);
    }

    /**
     * Get the gifts associated with the person.
     *
     * @return HasMany<Gift, $this>
     */
    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class);
    }

    /**
     * Get the tasks associated with the person.
     *
     * @return HasMany<Task, $this>
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the life events associated with the person.
     *
     * @return HasMany<LifeEvent, $this>
     */
    public function lifeEvents(): HasMany
    {
        return $this->hasMany(LifeEvent::class);
    }

    /**
     * Get the emailsSent associated with the person.
     *
     * @return HasMany<EmailSent, $this>
     */
    public function emailsSent(): HasMany
    {
        return $this->hasMany(EmailSent::class);
    }

    /**
     * Get the children where this person is the primary parent.
     *
     * @return HasMany<Child, $this>
     */
    public function childrenAsParent(): HasMany
    {
        return $this->hasMany(Child::class, 'parent_id', 'id');
    }

    /**
     * Get the children where this person is the second parent.
     *
     * @return HasMany<Child, $this>
     */
    public function childrenAsSecondParent(): HasMany
    {
        return $this->hasMany(Child::class, 'second_parent_id', 'id');
    }

    /**
     * Get all children related to this person (as either parent).
     *
     * @return Collection<Child>
     */
    public function children(): Collection
    {
        return $this->childrenAsParent->merge($this->childrenAsSecondParent);
    }

    /**
     * Get the person's full name.
     *
     * @return Attribute<string, never>
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
     * Get the person's current time based on their timezone.
     *
     * @return Attribute<string, never>
     */
    protected function currentTime(): Attribute
    {
        return Attribute::make(
            get: fn(): string => now($this->timezone)->format('g:i a'),
        );
    }

    /**
     * Get the person's age.
     * If the age type is exact, it will return the age from the special date.
     * If the age type is estimated, it will return the estimated age.
     * If the age type is unknown, it will return nothing.
     *
     * @return Attribute<string, never>
     */
    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn(): mixed => match ($this->age_type) {
                AgeType::EXACT->value => $this->ageSpecialDate ? $this->ageSpecialDate->ageOld : 'Unknown',
                AgeType::ESTIMATED->value => $this->getEstimatedAge(),
                default => $this->age_bracket,
            },
        );
    }

    /**
     * Calculate the estimated age based on when it was estimated.
     *
     * @return string The estimated age with "Probably" prefix
     */
    public function getEstimatedAge(): string
    {
        $years = (int) now()->diffInYears($this->age_estimated_at, true);
        $estimatedAge = (int) $this->estimated_age;

        return __('Probably :age years old', ['age' => $estimatedAge + $years]);
    }

    /**
     * Check if the person has an active love relationship.
     *
     * @return bool True if the person has an active relationship
     */
    public function hasActiveLoveRelationship(): bool
    {
        return $this->loveRelationships()
            ->where('is_current', true)
            ->exists();
    }

    /**
     * Get the active partners of the person as a collection of Person objects.
     *
     * @return SupportCollection The active partners of the person
     */
    public function getActivePartnersAsPersonCollection(): SupportCollection
    {
        $activeRelationships = LoveRelationship::where(function ($query): void {
            $query->where('person_id', $this->id)
                ->orWhere('related_person_id', $this->id);
        })
            ->where('is_current', true)
            ->with(['person', 'relatedPerson'])
            ->get();

        // get a collection of active partners
        $activePartners = collect();
        foreach ($activeRelationships as $relationship) {
            $partner = $relationship->person_id === $this->id
                ? $relationship->relatedPerson
                : $relationship->person;

            $activePartners->push($partner);
        }

        // filter out duplicates by person ID
        $activePartners = $activePartners->unique('id')->values();

        return $activePartners;
    }

    /**
     * Get the marital status of the person.
     *
     * @return string The marital status or relationship description
     */
    public function getMaritalStatus(): string
    {
        if (! $this->hasActiveLoveRelationship()) {
            return __(Crypt::decryptString($this->attributes['marital_status'] ?? ''));
        }

        $activeRelationships = LoveRelationship::where(function ($query): void {
            $query->where('person_id', $this->id)
                ->orWhere('related_person_id', $this->id);
        })
            ->where('is_current', true)
            ->with(['person', 'relatedPerson'])
            ->get();

        // Get unique partner names to avoid duplicates
        $partnerNames = collect();
        foreach ($activeRelationships as $relationship) {
            $partnerName = $relationship->person_id === $this->id
                ? $relationship->relatedPerson->name
                : $relationship->person->name;

            $partnerNames->push($partnerName);
        }
        $uniquePartnerNames = $partnerNames->unique()->values();

        if ($uniquePartnerNames->isEmpty()) {
            return __('In a relationship');
        }

        return __('In a relationship with :partners', [
            'partners' => $uniquePartnerNames->join(', ', ' and '),
        ]);
    }

    /**
     * Get the person's marital status as an attribute.
     *
     * @return Attribute<string, never>
     */
    protected function marital(): Attribute
    {
        return Attribute::make(
            get: fn(): mixed => $this->getMaritalStatus(),
        );
    }

    /**
     * Get the person's children status.
     *
     * @return string The children status
     */
    public function getChildrenStatus(): string
    {
        return match ($this->kids_status) {
            KidsStatusType::HAS_KIDS->value => $this->getChildrenNames(),
            KidsStatusType::MAYBE_KIDS->value => __('May have kids'),
            KidsStatusType::UNKNOWN->value => __('Unknown'),
            KidsStatusType::NO_KIDS->value => __('No kids'),
            default => __('Unknown'),
        };
    }

    /**
     * Get the person's children names.
     * Children can be created without names. We need to list the names of the
     * children that have names, and the count of the children that don't have
     * names.
     *
     * @return string The children names
     */
    public function getChildrenNames(): string
    {
        $children = $this->children();
        $namedChildren = $children->whereNotNull('first_name')->pluck('first_name');
        $unnamedCount = $children->whereNull('first_name')->count();
        $totalCount = $children->count();

        // If all children are unnamed
        if ($namedChildren->isEmpty()) {
            return $totalCount === 1 ? '1 kid' : $totalCount . ' kids';
        }

        // If there are no unnamed children
        if ($unnamedCount === 0) {
            return $namedChildren->join(', ', ' and ');
        }

        // If there are both named and unnamed children
        $namedPart = $namedChildren->join(', ', ' and ');
        return $unnamedCount === 1
            ? $namedPart . ' and 1 other kid'
            : $namedPart . ' and ' . $unnamedCount . ' other kids';
    }

    /**
     * Get the person's current job title if they have an active job.
     *
     * @return string|null The job title or null if no active job
     */
    public function job(): ?string
    {
        return $this->workHistories()
            ->where('active', true)
            ->first()?->job_title;
    }

    /**
     * Get the person's avatar URL.
     *
     * @param int $size The desired size of the avatar in pixels
     *
     * @return string The URL of the avatar
     */
    public function getAvatar(int $size = 64): string
    {
        return $this->profile_photo_path
            ? $this->resizedAvatar($size)
            : $this->defaultAvatar($size);
    }

    /**
     * Get the resized avatar URL for the person.
     *
     * @param int $size The desired size of the avatar in pixels
     *
     * @return string The URL of the resized avatar
     */
    protected function resizedAvatar(int $size = 64): string
    {
        return ImageHelper::getImageVariantPath($this->profile_photo_path, $size);
    }

    /**
     * Get the default avatar URL if no profile photo has been uploaded.
     *
     * @param int $size The desired size of the avatar in pixels
     * @return string The URL of the default avatar
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
            '&color=333333&background=' . $this->color . '&size=' . $size;
    }

    /**
     * Check if the person has any physical details.
     *
     * @return bool True if any physical detail is set, false otherwise
     */
    public function hasPhysicalDetails(): bool
    {
        return $this->height || $this->weight || $this->build ||
            $this->skin_tone || $this->face_shape || $this->eye_color ||
            $this->eye_shape || $this->hair_color || $this->hair_type ||
            $this->hair_length || $this->facial_hair || $this->scars ||
            $this->tatoos || $this->piercings || $this->distinctive_marks ||
            $this->glasses || $this->dress_style || $this->voice;
    }
}
