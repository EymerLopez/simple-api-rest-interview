<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
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
            'id_reg' => $this->id_reg,
            'code' => $this->code,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}
