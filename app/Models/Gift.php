<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

/**
 * Class Gift
 *
 * @property int $id
 * @property int $account_id
 * @property int $person_id
 * @property string $status
 * @property string $name
 * @property string|null $occasion
 * @property string|null $url
 * @property string|null $image_path
 * @property Carbon|null $gifted_at
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class Gift extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gifts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'person_id',
        'status',
        'name',
        'occasion',
        'url',
        'image_path',
        'gifted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name' => 'encrypted',
            'occasion' => 'encrypted',
            'url' => 'encrypted',
            'gifted_at' => 'datetime',
        ];
    }

    /**
     * Get the account associated with the gift.
     *
     * @return BelongsTo<Account, $this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the person associated with the gift.
     *
     * @return BelongsTo<Person, $this>
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
