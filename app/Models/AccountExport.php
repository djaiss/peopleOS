<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AgeType;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class AccountExport extends Model
{
    use HasFactory;

    protected $table = 'account_exports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'status',
        'uuid',
        'downloaded_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'status' => 'encrypted',
        'downloaded_at' => 'datetime',
    ];

    /**
     * Get the account associated with the account export.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
