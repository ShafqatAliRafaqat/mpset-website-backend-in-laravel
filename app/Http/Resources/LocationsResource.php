<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationsResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request) {
        return self::toLocation($this);
    }

    public static function toLocation($l){
        return [
            "id"=> $l->id ,
            "address"=> $l->address ,
            "lat"=> $l->lat ,
            "lng"=> $l->lng ,
        ];
    }
}
