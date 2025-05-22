<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

/**
 * Class Child
 *
 * @property int $id
 * @property int $account_id
 * @property int|null $parent_id
 * @property int|null $second_parent_id
 * @property int|null $age_special_date_id
 * @property int|null $gender_id
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $age_type
 * @property string|null $estimated_age
 * @property Carbon|null $age_estimated_at
 * @property string|null $profile_photo_path
 * @property string|null $notes
 * @property bool $is_born
 * @property Carbon|null $expected_birth_date_at
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class Child extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'children';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'parent_id',
        'second_parent_id',
        'age_special_date_id',
        'gender_id',
        'first_name',
        'last_name',
        'age_type',
        'estimated_age',
        'age_estimated_at',
        'profile_photo_path',
        'notes',
        'is_born',
        'expected_birth_date_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'first_name' => 'encrypted',
            'last_name' => 'encrypted',
            'age_type' => 'encrypted',
            'estimated_age' => 'encrypted',
            'age_estimated_at' => 'datetime',
            'notes' => 'encrypted',
            'is_born' => 'boolean',
            'expected_birth_date_at' => 'datetime',
        ];
    }

    /**
     * Get the account associated with the child.
     *
     * @return BelongsTo<Account, $this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the parent associated with the child.
     *
     * @return BelongsTo<Person, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'parent_id');
    }

    /**
     * Get the second parent associated with the child.
     *
     * @return BelongsTo<Person, $this>
     */
    public function secondParent(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'second_parent_id');
    }

    /**
     * Get the age special date associated with the child.
     *
     * @return BelongsTo<SpecialDate, $this>
     */
    public function ageSpecialDate(): BelongsTo
    {
        return $this->belongsTo(SpecialDate::class, 'age_special_date_id');
    }

    /**
     * Get the gender associated with the child.
     *
     * @return BelongsTo<Gender, $this>
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }
}
