<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkHistory extends Model
{
    use HasFactory;

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
            'active' => 'boolean',
        ];
    }

    /**
     * Get the person associated with the note.
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
