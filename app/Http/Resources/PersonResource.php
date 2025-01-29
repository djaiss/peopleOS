<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            'object' => 'person',
            'name' => $this->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'nickname' => $this->nickname,
            'maiden_name' => $this->maiden_name,
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
            'can_be_deleted' => $this->can_be_deleted,
            'is_listed' => $this->is_listed,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
        ];
    }
}
