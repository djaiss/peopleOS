<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Class Child
 *
 * @property int $id
 * @property int $account_id
 * @property int|null $parent_id
 * @property int|null $second_parent_id
 * @property string $first_name
 * @property string|null $last_name
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
        'account_id',
        'parent_id',
        'second_parent_id',
        'first_name',
        'last_name',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'first_name' => 'encrypted',
            'last_name' => 'encrypted',
        ];
    }

    /**
     * Get the account associated with the child.
     *
     * @return BelongsTo<Account, $this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
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

    /**
     * Get the person's full name.
     *
     * @return Attribute<string, never>
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $firstName = $this->first_name;
                $lastName = $this->last_name;
                $separator = $firstName && $lastName ? ' ' : '';

                return $firstName . $separator . $lastName;
            },
        );
    }
}
