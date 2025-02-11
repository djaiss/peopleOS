<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialDate extends Model
{
    use HasFactory;

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
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the person associated with the note.
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Get the special date's age.
     * The age is usually calculated based on the year, month, and day.
     * If the date is not exact, the age is calculated based on the year.
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

                return Carbon::createFromDate($this->year, $month, $day)->diffForHumans();
            }
        );
    }

    /**
     * Get the special date's friendly date.
     */
    protected function date(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes): string {
                if ($this->year && $this->month && $this->day) {
                    $date = CarbonImmutable::createFromDate($this->year, $this->month, $this->day);

                    return $date->format('M j, Y');
                }

                if ($this->year && ! $this->month && ! $this->day) {
                    $date = CarbonImmutable::createFromDate($this->year, 1, 1);

                    return $date->format('Y');
                }

                if ($this->year && $this->month && ! $this->day) {
                    $date = CarbonImmutable::createFromDate($this->year, $this->month, 1);

                    return $date->format('M j, Y');
                }

                if ($this->year && ! $this->month && $this->day) {
                    $date = CarbonImmutable::createFromDate($this->year, 1, $this->day);

                    return $date->format('Y');
                }

                if (! $this->year && $this->month && $this->day) {
                    $date = CarbonImmutable::createFromDate(1, $this->month, $this->day);

                    return $date->format('M j');
                }

                return '';
            }
        );
    }
}
