<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'active' => $this->is_active,
            'start' => $this->ads_starttime,
            'end' => $this->ads_endtime,
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
