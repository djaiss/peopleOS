<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class LoveRelationship
 *
 * @property int $id
 * @property int $person_id
 * @property int $related_person_id
 * @property string $type
 * @property bool $is_current
 * @property string|null $notes
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class LoveRelationship extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'love_relationships';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'person_id',
        'related_person_id',
        'type',
        'is_current',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => 'encrypted',
            'notes' => 'encrypted',
            'is_current' => 'boolean',
        ];
    }

    /**
     * Get the person who owns this relationship.
     *
     * @return BelongsTo<Person, $this>
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Get the related person in this relationship.
     *
     * @return BelongsTo<Person, $this>
     */
    public function relatedPerson(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'related_person_id');
    }
}
