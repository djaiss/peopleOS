<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'object' => 'gift',
            'name' => $this->name,
            'occasion' => $this->occasion,
            'url' => $this->url,
            'status' => $this->status,
            'gifted_at' => $this->gifted_at?->timestamp,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at?->timestamp,
        ];
    }
}
