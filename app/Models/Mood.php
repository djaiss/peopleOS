<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * Class Mood
 *
 * @property int $id
 * @property int $entry_id
 * @property string $mood
 * @property string|null $comment
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class Mood extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entries_mood';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'entry_id',
        'mood',
        'comment',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'comment' => 'encrypted',
        ];
    }

    /**
     * Get the entry associated with the mood.
     *
     * @return BelongsTo<Entry, $this>
     */
    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class, 'entry_id');
    }

    /**
     * Get the block associated with the mood.
     *
     * @return MorphOne<EntryBlock, $this>
     */
    public function block(): MorphOne
    {
        return $this->morphOne(EntryBlock::class, 'blockable');
    }
}
