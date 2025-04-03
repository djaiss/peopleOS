<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MarketingPage extends Model
{
    use HasFactory;

    protected $table = 'marketing_pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'url',
        'pageviews',
        'marked_helpful',
        'marked_not_helpful',
    ];

    /**
     * Get the users associated with the marketing page.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'marketing_page_user', 'marketing_page_id', 'user_id')
            ->using(MarketingPageUser::class)
            ->withPivot('helpful', 'comment')
            ->withTimestamps();
    }
}
