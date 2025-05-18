<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class MarketingPageUser
 *
 * @property int $marketing_page_id
 * @property int $user_id
 * @property bool $helpful
 * @property string|null $comment
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class MarketingPageUser extends Pivot
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'comment' => 'encrypted',
            'helpful' => 'boolean',
        ];
    }
}
