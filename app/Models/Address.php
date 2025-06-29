<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

/**
 * Class Address
 *
 * @property int $id
 * @property int $account_id
 * @property int|null $person_id
 * @property string|null $address_line_1
 * @property string|null $address_line_2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $postal_code
 * @property string|null $country
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class Address extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'person_id',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'address_line_1' => 'encrypted',
            'address_line_2' => 'encrypted',
            'city' => 'encrypted',
            'state' => 'encrypted',
            'postal_code' => 'encrypted',
            'country' => 'encrypted',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the account associated with the address.
     *
     * @return BelongsTo<Account, $this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the person associated with the address.
     *
     * @return BelongsTo<Person, $this>
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
