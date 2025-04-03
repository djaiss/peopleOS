<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MarketingPageUser extends Pivot
{
    protected function casts(): array
    {
        return [
            'comment' => 'encrypted',
            'helpful' => 'boolean',
        ];
    }
}
