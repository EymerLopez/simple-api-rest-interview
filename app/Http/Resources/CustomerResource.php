<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'dni' => $this->dni,
            'email' => $this->email,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'commune' => !$this->commune ? null : new CommuneResource($this->commune),
        ];
    }
}
