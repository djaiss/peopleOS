<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'object' => 'task',
            'name' => $this->name,
            'is_completed' => $this->is_completed,
            'due_at' => $this->due_at?->timestamp,
            'completed_at' => $this->completed_at?->timestamp,
            'task_category' => $this->taskCategory?->name,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at?->timestamp,
        ];
    }
}
