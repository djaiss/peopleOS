<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWaitlist extends Model
{
    use HasFactory;

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
        'status' => 'encrypted',
    ];
}
