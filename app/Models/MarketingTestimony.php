<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketingTestimony extends Model
{
    use HasFactory;

    protected $table = 'marketing_testimonies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'user_id',
        'status',
        'name_to_display',
        'url_to_point_to',
        'display_avatar',
        'testimony',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name_to_display' => 'encrypted',
            'url_to_point_to' => 'encrypted',
            'testimony' => 'encrypted',
            'display_avatar' => 'boolean',
        ];
    }

    /**
     * Get the account associated with the testimony.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the user associated with the testimony.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
