<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'object' => 'contact',
            'gender' => new GenderResource($this->gender),
            'ethnicity' => new EthnicityResource($this->ethnicity),
            'name' => $this->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'nickname' => $this->nickname,
            'maiden_name' => $this->maiden_name,
            'patronymic_name' => $this->patronymic_name,
            'tribal_name' => $this->tribal_name,
            'generation_name' => $this->generation_name,
            'romanized_name' => $this->romanized_name,
            'nationality' => $this->nationality,
            'marital_status' => $this->marital_status,
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
            'can_be_deleted' => $this->can_be_deleted,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
        ];
    }
}
