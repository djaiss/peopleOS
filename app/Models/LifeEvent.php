<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

/**
 * Class LifeEvent
 *
 * @property int $id
 * @property int $account_id
 * @property int|null $person_id
 * @property int|null $special_date_id
 * @property string $description
 * @property string|null $comment
 * @property string|null $icon
 * @property string|null $bg_color
 * @property string|null $text_color
 * @property Carbon|null $happened_at
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class LifeEvent extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'life_events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'person_id',
        'special_date_id',
        'description',
        'comment',
        'icon',
        'bg_color',
        'text_color',
        'happened_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'description' => 'encrypted',
            'comment' => 'encrypted',
            'happened_at' => 'datetime',
        ];
    }

    /**
     * Get the account that owns the life event.
     *
     * @return BelongsTo<Account, $this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the person associated with the life event.
     *
     * @return BelongsTo<Person, $this>
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
    * Get the special date associated with the life event.
    *
    * A special date relationship indicates if this life event serves as a
    * reminder, since the reminder functionality is managed through special
    * dates.
     *
     * @return BelongsTo<SpecialDate, $this>
     */
    public function specialDate(): BelongsTo
    {
        return $this->belongsTo(SpecialDate::class);
    }
}
