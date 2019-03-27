<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Event;

class EventDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {


        $data = EventsResource::toEvent($this);

        $players = 0;

        if(isset($this->users)){
            $players = sizeof($this->users);
        }



        return array_merge($data,[

            'no_of_players' => $players,
            'available_seats' => ($this->max_players - $players),
            'game_profile_string' => Event::$GAME_PROFILES[$this->game_profile],
            'max_players' => $this->max_players,
            'min_players' => $this->min_players,
            'table_rules' => $this->table_rules,
            'purchase_amount' => $this->purchase_amount,
            're_buyins' => $this->re_buyins,
            'small_blind' => $this->small_blind,
            'big_blind' => $this->big_blind,
            'max_buyins' => $this->max_buyins,
            'min_buyins' => $this->min_buyins,
            'rating' => ($this->rating)? :"0",
            'valid_start_date' => $this->valid_start_date,
            'valid_end_date' => $this->valid_end_date,
            'stats' => isset($this->stats)?$this->stats:"",
            'host' => UsersResource::make($this->whenLoaded('host')),
            'location' => LocationResource::make($this->whenLoaded('location')),
            'users' => UsersResource::collection($this->whenLoaded('users')),

        ]);

    }
}
