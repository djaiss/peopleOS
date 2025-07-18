<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class SpecialDate
 *
 * @property int $id
 * @property int $account_id
 * @property int|null $person_id
 * @property bool $should_be_reminded
 * @property int|null $year
 * @property int|null $month
 * @property int|null $day
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class SpecialDate extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'special_dates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'person_id',
        'should_be_reminded',
        'year',
        'month',
        'day',
        'name',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'should_be_reminded' => 'boolean',
            'name' => 'encrypted',
        ];
    }

    /**
     * Get the account associated with the special date.
     *
     * @return BelongsTo<Account, $this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the person associated with the special date.
     *
     * @return BelongsTo<Person, $this>
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Get the special date's age, like "29 years ago".
     * The age is usually calculated based on the year, month, and day.
     * If the date is not exact, the age is calculated based on the year.
     *
     * @return Attribute<string, never>
     */
    protected function age(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes): string {
                if (! $this->year) {
                    return 'Unknown';
                }

                $day = $attributes['day'] ?? 1;
                $month = $attributes['month'] ?? 1;

                return Carbon::createFromDate($this->year, $month, $day)
                    ->diffForHumans();
            },
        );
    }

    /**
     * Get the special date's age, like "29 years old".
     * The age is usually calculated based on the year, month, and day.
     * If the date is not exact, the age is calculated based on the year.
     *
     * @return Attribute<string, never>
     */
    protected function ageOld(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes): string {
                if (! $this->year) {
                    return 'Unknown';
                }

                $day = $attributes['day'] ?? 1;
                $month = $attributes['month'] ?? 1;

                $age = Carbon::createFromDate($this->year, $month, $day)->age;

                return trans_choice(
                    ':count year old|:count years old',
                    $age,
                    ['count' => $age],
                );
            },
        );
    }

    /**
     * Get the special date's friendly date.
     *
     * @return Attribute<string, never>
     */
    protected function date(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes): string {
                // we have the year, month, and day
                if ($this->year && $this->month && $this->day) {
                    $date = CarbonImmutable::createFromDate(
                        year: $this->year,
                        month: $this->month,
                        day: $this->day,
                    );

                    return $date->format('M j, Y');
                }

                // we have the year, but no month or day
                if ($this->year && ! $this->month && ! $this->day) {
                    $date = CarbonImmutable::createFromDate(
                        year: $this->year,
                        month: 1,
                        day: 1,
                    );

                    return $date->format('Y');
                }

                // we have the year, and month, but no day
                if ($this->year && $this->month && ! $this->day) {
                    $date = CarbonImmutable::createFromDate(
                        year: $this->year,
                        month: $this->month,
                        day: 1,
                    );

                    return $date->format('M j, Y');
                }

                // we have the year, and day, but no month
                if ($this->year && ! $this->month && $this->day) {
                    $date = CarbonImmutable::createFromDate(
                        year: $this->year,
                        month: 1,
                        day: $this->day,
                    );

                    return $date->format('Y');
                }

                // we have the month and day, but no year
                if (! $this->year && $this->month && $this->day) {
                    $date = CarbonImmutable::createFromDate(
                        year: 1,
                        month: $this->month,
                        day: $this->day,
                    );

                    return $date->format('M j');
                }

                // we have the day, but no year or month
                if (! $this->year && ! $this->month && $this->day) {
                    $date = CarbonImmutable::createFromDate(
                        year: 1,
                        month: 1,
                        day: $this->day,
                    );

                    return $date->format('j');
                }

                return '';
            },
        );
    }

    /**
     * Get the date as a string, like "2023-10-01".
     *
     * @return string
     */
    public function dateAsString(): string
    {
        return Carbon::parse(
            $this->year . '-' . $this->month . '-' . $this->day,
        )->format('Y-m-d');
    }
}
