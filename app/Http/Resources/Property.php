<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Property extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'street' => $this->street,
            'number' => $this->number,
            'complement' => $this->complement,
            'district' => $this->district,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'city' => new City($this->whenLoaded('city')),
            'contract' => new Contract($this->whenLoaded('contract')),
        ];
    }
}