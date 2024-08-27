<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;

class Child extends Model
{
    use HasFactory;

    protected $table = 'children';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'contact_id',
        'gender',
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'encrypted',
        'gender' => 'encrypted',
    ];

    /**
     * Get the contact record associated with the note.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the name of the child.
     *
     * If the name is not set, we should return the gender in a sentence, like
     * "a boy".
     *
     * @return Attribute<string,never>
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (Arr::get($attributes, 'name')) {
                    return Crypt::decryptString($value);
                } else {
                    return match ($this->gender) {
                        Contact::GENDER_MALE => trans('a boy'),
                        Contact::GENDER_FEMALE => trans('a girl'),
                        Contact::GENDER_OTHER => trans('unknown'),
                    };
                }
            }
        );
    }
}
