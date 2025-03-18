<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This model tracks when the user has seen a specific person.
 */
class Gift extends Model
{
    use HasFactory;

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
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => 'encrypted',
            'name' => 'encrypted',
            'occasion' => 'encrypted',
            'url' => 'encrypted',
        ];
    }

    /**
     * Get the account associated with the person seen report.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the person associated with the person seen report.
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
