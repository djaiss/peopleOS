<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [];

    /**
     * Get the logs associated with the account.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class);
    }

    /**
     * Get the users associated with the account.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the offices associated with the account.
     */
    public function offices(): HasMany
    {
        return $this->hasMany(Office::class);
    }

    /**
     * Get the teams associated with the account.
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}
