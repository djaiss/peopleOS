<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LifeEventResource extends JsonResource
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
            'object' => 'life_event',
            'description' => $this->description,
            'comment' => $this->comment,
            'icon' => $this->icon,
            'bg_color' => $this->bg_color,
            'text_color' => $this->text_color,
            'happened_at' => $this->happened_at?->timestamp,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at?->timestamp,
        ];
    }
}
