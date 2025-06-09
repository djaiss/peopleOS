<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Represents a block of content within a journal entry.
 *
 * This model serves as a polymorphic bridge between entries and their various
 * content types (moods, eating logs, etc.). Each block has a position to
 * maintain order within the entry.
 *
 * @property int $id
 * @property int $entry_id
 * @property string $blockable_type
 * @property int $blockable_id
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Entry $entry
 * @property-read Model $blockable
 */
class EntryBlock extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'entries_blocks';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'entry_id',
        'blockable_type',
        'blockable_id',
        'position',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'entry_id' => 'integer',
        'blockable_id' => 'integer',
        'position' => 'integer',
    ];

    /**
     * Get the entry that owns this block.
     *
     * @return BelongsTo<Entry, $this>
     */
    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    /**
     * Get the blockable model (polymorphic relationship).
     *
     * @return MorphTo<Model, $this>
     */
    public function blockable(): MorphTo
    {
        return $this->morphTo();
    }
}
