<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersResource;
use App\Http\Resources\LocationResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Event;

class EventsResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request){
        return self::toEvent($this);
    }

    public static function toEvent($e){


        $status = $e->status ;

        if($e->pivot && $e->pivot->isCanceled == 1){
            $status = Event::$CANCELED;
        }

        $duration = 0;

        if($e->start_time && $e->end_time){
            $duration = $e->end_time->diffInMinutes($e->start_time);
        }

        return [
            'id' => $e->id,
            'name' => $e->name,
            'status' => Event::$STATUS[$status],
            'game_type_string' => $e->game_type,
            'PublicStatus' => ($e->isPrivate)?"Private":"Public",
            'date_string' => $e->game_date->format('M j, Y g:i A'),
            'date' => $e->game_date,
            'time' => $e->game_date->format('H:i'),
            'duration' => $duration,
            'rating' => rand(0,5),
            "address" => ($e->location)?$e->location->address:"",
			"lat" => ($e->location)?$e->location->lat:"",
			"lng" => ($e->location)?$e->location->lng:"",
            "host_name" => ($e->host) ? $e->host->first_name:"",
            'PlayerStatus' => ($e->host_id == Auth::user()->id) ? "Host":"Player",
            'no_of_players' => $e->no_of_players,
            'pivot' => $e->whenLoaded('pivot'),
            'min_players' => $e->min_players,
        ];
    }

}
