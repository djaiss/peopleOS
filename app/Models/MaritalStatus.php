<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaritalStatus extends Model
{
    use HasFactory;

    protected $table = 'marital_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'type',
        'name',
        'position',
        'can_be_deleted',
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
            'name' => 'encrypted',
            'position' => 'integer',
            'can_be_deleted' => 'boolean',
        ];
    }

    /**
     * Get the account associated with the team.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
