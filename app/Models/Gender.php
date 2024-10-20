<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'label' => 'encrypted',
    ];

    /**
     * Get the account associated with the gender.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the contacts associated with the gender.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get the name of label attribute.
     * Gender entries have a default label that can be translated.
     * Howerer, if a label is already set, it will be used instead of the default.
     * This was supposed to be a mutator initally, using laravel Attributes.
     * However, you can't have a mutator for an encrypted attribute at the time
     * of writing this code. So we have to resort to an old fashioned getter.
     */
    public function getLabel(): string
    {
        return $this->label ?: __($this->label_translation_key);
    }
}
