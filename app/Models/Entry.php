<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
