<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Model for the changelogs table.
 *
 * @property int $id
 * @property string $pull_request_url
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property Carbon $published_at
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class Changelog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'changelogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pull_request_url',
        'title',
        'description',
        'slug',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }
}
