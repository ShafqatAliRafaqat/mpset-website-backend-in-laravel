<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return $this->toUser($this);
    }

    public static function toUser($u){
        $host = env('APP_URL','http://localhost:8000');
        return [
            'id' => $u->id,
            'nick_name' => $u->nick_name,
            'first_name' => $u->first_name,
            'last_name' => $u->last_name,
            'email' => $u->email,
            'rating' => isset($u->rating)?$u->rating:null,
            'avatar' => ($u->avatar)?"$host/$u->avatar":"$host/defaults/avatar/avatar.png",
            'emailVerified' => (bool)$u->email_verified_at,
            'pivot' => isset($u->pivot)?$u->pivot:null
        ];
    }
}
