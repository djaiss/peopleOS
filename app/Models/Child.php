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
 * @property int $person_id
 * @property int|null $parent_id
 * @property int|null $second_parent_id
 * @property string|null $notes
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
        'person_id',
        'parent_id',
        'second_parent_id',
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
            'notes' => 'encrypted',
        ];
    }

    /**
     * Get the person associated with the child.
     *
     * @return BelongsTo<Person, $this>
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
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
}
