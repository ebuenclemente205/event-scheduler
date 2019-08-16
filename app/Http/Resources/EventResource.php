<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'from' => $this->from,
            'to' => $this->to,
            'days' => $this->days,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
