<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
