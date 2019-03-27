<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {

    public function userGrowth(Request $request){

        $start = Carbon::now()->startOfYear()->toDateTimeString();
        $end = Carbon::now()->endOfYear()->toDateTimeString();

        if($request->start_date){
            $start = Carbon::parse($request->start_date)->toDateTimeString();
        }

        if($request->end_date){
            $end = Carbon::parse($request->end_date)->toDateTimeString();
        }

        $data = DB::select("SELECT COUNT(users.id) as users,
                CONCAT(MONTHName(users.created_at),CONCAT(' ',YEAR(users.created_at))) as monthYear,created_at
                FROM `users` WHERE 
                created_at >= '$start' && created_at <= '$end' GROUP by monthYear ORDER by created_at");

        return $data;

    }

    public function eventStats(Request $request){

        $start = Carbon::now()->startOfYear()->toDateTimeString();
        $end = Carbon::now()->endOfYear()->toDateTimeString();

        if($request->start_date){
            $start = Carbon::parse($request->start_date)->toDateTimeString();
        }

        if($request->end_date){
            $end = Carbon::parse($request->end_date)->toDateTimeString();
        }

        $data = DB::select("SELECT COUNT(events.id) as events,
                CONCAT(MONTHName(events.created_at),CONCAT(' ',YEAR(events.created_at))) as monthYear,created_at
                FROM `events` WHERE 
                created_at >= '$start' && created_at <= '$end' GROUP by monthYear ORDER by created_at");

        return $data;

    }

    public function countryUsers(){

        $array = DB::select("SELECT count(u.id) as users,user_detail.country,user_detail.country_code FROM users u INNER JOIN user_detail ON u.id = user_detail.user_id GROUP by user_detail.country_code ORDER by users DESC");

        return [
            'data' => $array
        ];
    }

    public function stats(){

        $status = Event::$STARTED;

        $array = DB::select("SELECT 
                    count(events.id) as allEvents,
                    (select COUNT(u.id) From users u) as  allUsers,
                    (select COUNT(e.id) From events e WHERE e.isPrivate=1) as privateEvents,
                    (select COUNT(e.id) From events e WHERE e.isPrivate=0) as publicEvents,
                    (select COUNT(e.id) From events e WHERE e.status='$status') as onGoingEvents
                    FROM events");

        $data = reset($array);

        return [
            'data' => $data
        ];
    }

}
