<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Log
 *
 * Represents a log entry in the system for tracking user actions and events.
 */
class Log extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'user_id',
        'user_name',
        'action',
        'description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_name' => 'encrypted',
            'action' => 'encrypted',
            'description' => 'encrypted',
        ];
    }

    /**
     * Get the account associated with the log.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the user associated with the log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user name associated with the log.
     * If the user object exists, return the name from the user object.
     * If the user object does not exist, return the user name that was set in
     * the log at the time of creation.
     *
     * @return Attribute<string, never>
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $user = $this->user;

                return $user ? $user->name : $this->user_name;
            },
        );
    }
}
