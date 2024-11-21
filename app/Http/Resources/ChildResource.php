<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildResource extends JsonResource
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
            'object' => 'child',
            'contact' => $this->contact ? [
                'id' => $this->contact->id,
                'name' => $this->contact->name,
            ] : null,
            'gender' => $this->gender,
            'name' => $this->name,
            'age' => $this->age,
            'grade_level' => $this->grade_level,
            'school' => $this->school,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
        ];
    }
}
