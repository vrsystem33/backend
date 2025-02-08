<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'uuid' => $this->uuid,
            'company_id' => $this->company_id,
            'status' => $this->status,
            'name' => $this->personInfo->name,
            'phone' => $this->personInfo->phone,
            'email' => $this->personInfo->email,
            'address' => $this->address->address,
            'postal_code' => $this->address->postal_code,
            'city' => $this->address->city,
            'state' => $this->address->state,
            // 'person_info' => [
            // ],
            // 'address' => [
            // ],
        ];
    }
}
