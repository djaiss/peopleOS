<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class WorkHistory
 *
 * @property int $id
 * @property int $person_id
 * @property string|null $company_name
 * @property string|null $job_title
 * @property string|null $duration
 * @property string|null $estimated_salary
 * @property bool $active
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class WorkHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_information';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'person_id',
        'company_name',
        'job_title',
        'duration',
        'estimated_salary',
        'active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'company_name' => 'encrypted',
            'job_title' => 'encrypted',
            'estimated_salary' => 'encrypted',
            'duration' => 'encrypted',
            'active' => 'boolean',
        ];
    }

    /**
     * Get the person associated with the work history.
     *
     * @return BelongsTo<Person, $this>
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
