<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommuneResource extends JsonResource
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
            'id_com' => $this->id_com,
            'code' => $this->code,
            'description' => $this->description,
            'status' => $this->status,
            'region' => !$this->region ? null : new RegionResource($this->region),
        ];
    }
}
