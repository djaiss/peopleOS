<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class UserWaitlist
 *
 * @property int $id
 * @property string $email
 * @property string|null $confirmation_code
 * @property Carbon|null $confirmed_at
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class UserWaitlist extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_waitlist';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'email',
        'confirmation_code',
        'confirmed_at',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'confirmed_at' => 'datetime',
        'email' => 'encrypted',
        'confirmation_code' => 'encrypted',
    ];
}
