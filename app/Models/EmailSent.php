<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailSent extends Model
{
    use HasFactory;

    protected $table = 'emails_sent';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'account_id',
        'person_id',
        'uuid',
        'email_type',
        'email_address',
        'subject',
        'body',
        'sent_at',
        'delivered_at',
        'bounced_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_type' => 'encrypted',
        'email_address' => 'encrypted',
        'subject' => 'encrypted',
        'body' => 'encrypted',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'bounced_at' => 'datetime',
    ];

    /**
     * Get the account that owns the email.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the person associated with the email.
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
