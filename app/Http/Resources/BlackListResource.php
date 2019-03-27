<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlackListResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    
    public function toArray($request) {
        
        return [
            'id' => $this->id,
            'all_features' => (bool)$this->all_features,
            'country_code' => $this->country_code,
            'country' => $this->country,
            'features' => json_decode($this->features,true),
        ];
    }
}
