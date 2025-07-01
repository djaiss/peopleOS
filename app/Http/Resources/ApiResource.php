<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'api_key',
            'id' => (string) $this->id,
            'attributes' => [
                'name' => $this->name,
                'token' => $this->additional['token'] ?? null,
                'last_used_at' => $this->last_used_at ? $this->last_used_at->timestamp : null,
                'created_at' => $this->created_at->timestamp,
                'updated_at' => $this->updated_at->timestamp,
            ],
            'links' => [
                'self' => route('api.administration.api.show', $this->id),
            ],
        ];
    }
}
