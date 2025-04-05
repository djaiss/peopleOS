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
            'age' => [
                'age_type' => $this->age_type,
                'age' => $this->age,
            ],
            'how_we_met' => $this->how_we_met,
            'can_be_deleted' => $this->can_be_deleted,
            'is_listed' => $this->is_listed,
            'physical_appearance' => [
                'height' => $this->height,
                'weight' => $this->weight,
                'build' => $this->build,
                'skin_tone' => $this->skin_tone,
                'face_shape' => $this->face_shape,
                'eye_color' => $this->eye_color,
                'eye_shape' => $this->eye_shape,
                'hair_color' => $this->hair_color,
                'hair_type' => $this->hair_type,
                'hair_length' => $this->hair_length,
                'facial_hair' => $this->facial_hair,
                'scars' => $this->scars,
                'tatoos' => $this->tatoos,
                'piercings' => $this->piercings,
                'distinctive_marks' => $this->distinctive_marks,
                'glasses' => $this->glasses,
                'dress_style' => $this->dress_style,
                'voice' => $this->voice,
            ],
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
        ];
    }
}
