<?php

namespace App\Models;

use App\Enums\ChildGender;
use Carbon\Carbon;
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
        'age',
        'grade_level',
        'school',
        'age_entered_at', // when the age was entered in the system, used to calculate the age
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'encrypted',
        'gender' => 'encrypted',
        'age' => 'integer',
        'grade_level' => 'encrypted',
        'school' => 'encrypted',
        'age_entered_at' => 'datetime',
    ];

    /**
     * Get the contact record associated with the child.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the name of the child.
     * If the name is defined, it will return the name.
     * If the name is not defined, it will return the gender as a name.
     *
     * @return Attribute<string,string>
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (Arr::get($attributes, 'name')) {
                    return Crypt::decryptString(Arr::get($attributes, 'name'));
                }

                return match ($this->gender) {
                    ChildGender::BOY->value => trans('a boy'),
                    ChildGender::GIRL->value => trans('a girl'),
                    default => trans('a child'),
                };
            }
        );
    }

    /**
     * Get the age of the child.
     * The age is automatically calculated based on the number of years
     * originally defined and the current year.
     *
     * @return Attribute<int|null,int|null>
     */
    protected function age(): ?Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (! Arr::get($attributes, 'age')) {
                    return null;
                }

                $age = Arr::get($attributes, 'age');
                $ageEnteredAt = Carbon::parse(Arr::get($attributes, 'age_entered_at'));

                return $age + round($ageEnteredAt->diffInYears(now()));
            }
        );
    }
}
