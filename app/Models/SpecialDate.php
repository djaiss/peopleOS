<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
            get: function (mixed $value, array $attributes): int {
                if (! $this->year) {
                    return 0;
                }

                $day = $attributes['day'] ?? 1;
                $month = $attributes['month'] ?? 1;

                $date = Carbon::createFromDate($this->year, $month, $day);

                return (int) now()->diffInYears($date, true);
            }
        );
    }
}
