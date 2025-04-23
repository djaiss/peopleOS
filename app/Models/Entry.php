<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Entry extends Model
{
    use HasFactory;

    protected $table = 'entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'journal_id',
        'day',
        'month',
        'year',
    ];

    /**
     * Get the journal associated with the entry.
     */
    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    /**
     * Get the mood associated with the entry.
     */
    public function mood(): HasOne
    {
        return $this->hasOne(Mood::class, 'entry_id', 'id');
    }

    /**
     * Get the date of the entry, in a human readable format, like "2024/12/23".
     */
    public function getDate(): string
    {
        return Carbon::create($this->year, $this->month, $this->day)->format('Y/m/d');
    }
}
