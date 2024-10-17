<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gender extends Model
{
    use HasFactory;

    protected $table = 'genders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'account_id',
        'label',
        'label_translation_key',
    ];

    /**
     * Get the account associated with the vault.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the name of label attribute.
     * Gender entries have a default label that can be translated.
     * Howerer, if a label is already set, it will be used instead of the default.
     *
     * @return Attribute<string, string>
     */
    protected function label(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (! $value) {
                    return __($attributes['label_translation_key']);
                }

                return $value;
            },
            set: fn (?string $value) => $value,
        );
    }
}
