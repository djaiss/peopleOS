<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LifeEvent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
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
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'description' => 'encrypted',
        'comment' => 'encrypted',
    ];

    /**
     * Get the account that owns the life event.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the person associated with the life event.
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Get the special date associated with the life event.
     */
    public function specialDate(): BelongsTo
    {
        return $this->belongsTo(SpecialDate::class);
    }
}
