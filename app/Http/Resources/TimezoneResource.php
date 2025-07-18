<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimezoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'timezone',
            'attributes' => [
                'timezone' => $this->timezone,
            ],
            'links' => [
                'self' => route('api.me'),
            ],
        ];
    }
}
