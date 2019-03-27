<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    
    protected $guarded  = [
        'id'
    ];

    protected $dates = [
        'game_date',
        'start_time',
        'end_time',
        'valid_start_date',
        'valid_end_date'
    ];

    public static $TOURNAMENT = 'tournament';
    public static $CASH = 'cash';
    public static $BOTH = 'cash/tournament';

    public static $TEXAS_HOLDEM = 'texas_holdem';
    public static $OMAHA = 'omaha';
    public static $DEALER_CHOICE = 'dealer_choice';
    
    public static $NOT_STARTED = 'not_started';
    public static $PENDING_VOTING = 'pending_voting';
    public static $VOTING_FINALIZED = 'voting_finalized';
    public static $STARTED = 'started';
    public static $COMPLETED = 'completed';
    public static $CANCELED = 'canceled';


    public static $STATUS = [
        'not_started' => 'Not Started',
        'pending_voting' => 'Pending voting',
        'voting_finalized' => 'Voting Finalized',
        'started' => 'Started',
        'completed' => 'Completed',
        'canceled' => 'Canceled',
    ];

    public static $GAME_TYPES = [
        'tournament' => 'Tournament',
        'cash' => 'Cash',
        'cash/tournament' => 'Cash/Tournament',
    ];

    public static $GAME_PROFILES = [
        'texas_holdem' => 'Texas Holdem',
        'omaha' => 'Omaha',
        'dealer_choice' => 'Dealer Choice',
    ];

    public function location() {
        return $this->belongsTo('App\Location','location_id','id');
    }

    public function users(){
        return $this->belongsToMany('App\User','user_event','event_id','user_id')
        ->withPivot('buyins', 'checkout','isApproved','seat_no','isCanceled','start_date','end_date')
    	->withTimestamps();
    }

    public function host() {
        return $this->belongsTo('App\User','host_id','id');
    }

    public function reviews(){
        return $this->hasMany('App\Review','event_id','id');
    }

    public function audits(){
        return $this->hasMany('App\EventAudit','event_id','id');
    }

    public function hostReview(){
        return $this->hasOne('App\Review','host_event_id','id');
    }

    public static function GET_PLAYED_TIME($id){
        
        $stats  = self::GET_EVENT_STATS($id);
        
        $played_time = $stats->minutes;

        return ($played_time)?$played_time:0;
    }

    public static  function GET_EVENT_STATS($user_id){
        $data = DB::select("SELECT 
        SUM(TIMESTAMPDIFF(SECOND, events.start_time, events.end_time))/60 as minutes,
        COUNT(events.id) as no_of_events,
        sum(user_event.buyins) as buyins,
        sum(user_event.checkout) as checkout 
        FROM events 
        INNER JOIN user_event ON events.id = user_event.event_id 
        WHERE user_event.user_id=$user_id");
        return $data[0];
    }

    public static  function GET_EVENT_STATS_ByID($id){
        $data = DB::select("SELECT 
        SUM(TIMESTAMPDIFF(SECOND, events.start_time, events.end_time))/60 as minutes,
        COUNT(events.id) as no_of_events,
        sum(user_event.buyins) as buyins,
        sum(user_event.checkout) as checkout 
        FROM events 
        INNER JOIN user_event ON events.id = user_event.event_id 
        WHERE user_event.id=$id");

        $stat = $data[0];

        $stat->minutes = ($stat->minutes)?$stat->minutes:0;
        $stat->no_of_events = ($stat->no_of_events)?$stat->no_of_events:0;
        $stat->buyins = ($stat->buyins)?$stat->buyins:0;
        $stat->checkout = ($stat->checkout)?$stat->checkout:0;

        return $data[0];
    }

    public static  function GET_EVENT_AND_LOCATION_STATS($user_id){
        $data = DB::select("SELECT 
        locations.address,
        SUM(TIMESTAMPDIFF(SECOND, events.start_time, events.end_time))/60 as minutes,
        COUNT(events.id) as no_of_events,
        sum(user_event.buyins) as buyins,
        sum(user_event.checkout) as checkout 
        FROM events 
        INNER JOIN locations ON events.location_id = locations.id 
        INNER JOIN user_event ON events.id = user_event.event_id 
        WHERE locations.user_id=$user_id");
        
        return $data;
    } 

   
}
