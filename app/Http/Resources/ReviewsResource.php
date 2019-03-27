<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    
    public function toArray($request) {
        return [
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => $this->created_at->diffForHumans(),
            'reviewer' => UsersResource::make($this->reviewer)
        ];
    }
}
