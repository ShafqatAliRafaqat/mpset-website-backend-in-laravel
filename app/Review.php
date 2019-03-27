<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Review extends Model {

    protected $guarded = [
        'id'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function reviewer() {
        return $this->belongsTo('App\User', 'reviewer_id', 'id');
    }

    public function event() {
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }

    public function location() {
        return $this->belongsTo('App\Location', 'location_id', 'id');
    }

    public static function GET_EVENT_RATING($id){
        $data = DB::select("SELECT sum(r.rating)/count(r.rating) as rating from reviews r where r.event_id = $id");
        $rating = $data[0]->rating;
        return ($rating)?$rating:0;
    }

    public static function GET_LOCATION_RATING($id){
        $l_rating = DB::select("SELECT sum(r.rating)/count(r.rating) as rating from reviews r where r.location_id = $id");
        $l_rating = $l_rating[0]->rating;
        return ($l_rating)?$l_rating:0;
    }

    public static function GET_PLAYER_RATING($id){
        $u_rating = DB::select("SELECT sum(r.rating)/count(r.rating) as rating from reviews r where r.asHost = 0 AND r.user_id = $id");
        $u_rating = $u_rating[0]->rating;
        return ($u_rating)?$u_rating:0;
    }

    public static function GET_HOST_RATING($id){
        $h_rating = DB::select("SELECT sum(r.rating)/count(r.rating) as rating from reviews r where r.asHost = 1 AND r.user_id = $id");
        $h_rating = $h_rating[0]->rating;
        return ($h_rating)?$h_rating:0;
    }
    
}
