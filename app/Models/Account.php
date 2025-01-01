<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'storage_limit_in_mb',
    ];

    /**
     * Get the users associated with the account.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the genders associated with the account.
     */
    public function genders(): HasMany
    {
        return $this->hasMany(Gender::class);
    }

    /**
     * Get the ethnicities associated with the account.
     */
    public function ethnicities(): HasMany
    {
        return $this->hasMany(Ethnicity::class);
    }

    /**
     * Get the marital statuses associated with the account.
     */
    public function maritalStatuses(): HasMany
    {
        return $this->hasMany(MaritalStatus::class);
    }

    /**
     * Get the vaults associated with the account.
     */
    public function vaults(): HasMany
    {
        return $this->hasMany(Vault::class);
    }

    /**
     * Get the templates associated with the account.
     */
    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }
}
