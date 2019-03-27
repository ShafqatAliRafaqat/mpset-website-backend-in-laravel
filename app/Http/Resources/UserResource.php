<?php

namespace App\Http\Resources;

use App\Http\Resources\LocationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request){


        $details = $this->userDetail;

        $userData = UsersResource::toUser($this);

        return array_merge($userData,[
            'phone' => $details->phone,
            'gender' => $details->gender,
            'address' => $details->address,
            'notification_status' => $details->notification_status,
            'location' => LocationResource::make($this->location),
        ]);

    }
}
