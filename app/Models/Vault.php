<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vault extends Model
{
    use HasFactory;

    /**
     * Possible vault permissions.
     */
    public const PERMISSION_VIEW = 300;

    public const PERMISSION_EDIT = 200;

    public const PERMISSION_MANAGE = 100;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'name',
        'description',
        'show_group_tab',
        'show_tasks_tab',
        'show_files_tab',
        'show_journal_tab',
        'show_companies_tab',
        'show_calendar_tab',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'show_group_tab' => 'boolean',
        'show_calendar_tab' => 'boolean',
        'show_tasks_tab' => 'boolean',
        'show_files_tab' => 'boolean',
        'show_journal_tab' => 'boolean',
        'show_companies_tab' => 'boolean',
        'show_reports_tab' => 'boolean',
    ];

    /**
     * Get the account associated with the vault.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the users associated with the vault.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('permission')
            ->withTimestamps();
    }

    /**
     * Get the contact associated with the vault.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
