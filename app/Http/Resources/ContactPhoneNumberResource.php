<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactPhoneNumberResource extends JsonResource
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
            'object' => 'contact_phone_number',
            'contact' => [
                'id' => $this->contact->id,
                'name' => $this->contact->name,
            ],
            'label' => $this->label,
            'phone_number' => $this->phone_number,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
        ];
    }
}
