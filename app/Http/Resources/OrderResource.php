<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'client_id' => $this->client_id,
            'place' => $this->place,
            'video' => $this->video,
            'image_one' =>$this->image_one,
            'image_two' =>$this->image_two,
            'longitude' =>$this->longitude,
            'latitude' =>$this->latitude,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
