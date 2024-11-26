<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
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
            'object' => 'partner',
            'contact' => $this->contact ? [
                'id' => $this->contact->id,
                'name' => $this->contact->name,
            ] : null,
            'marital_status' => $this->maritalStatus ? [
                'id' => $this->maritalStatus->id,
                'label' => $this->maritalStatus->getLabel(),
            ] : null,
            'name' => $this->name,
            'occupation' => $this->occupation,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
        ];
    }
}
