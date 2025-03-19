<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskCategoryResource extends JsonResource
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
            'object' => 'task_category',
            'name' => $this->name,
            'color' => $this->color,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at?->timestamp,
        ];
    }
}
