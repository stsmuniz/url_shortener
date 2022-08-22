<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'original_url' => $this->original_url,
            'shortened_url' => url()->to('/') .'/'. $this->shortened_url,
            'access_count' => $this->access_count,
            'expiration_date' => $this->expiration_date,
            'active' => $this->active,
        ];
    }
}
