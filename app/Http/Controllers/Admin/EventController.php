<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class EventController extends Controller{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $events =  Event::all();
        return view('admin.events.index',['events'=>$events]);
    }
    public function addEvent()
    {
        return view('admin.events.create');
    }
     public function ongoingEvent()
    {
        $events =  Event::where('event_status',1)->get();
        return view('admin.events.ongoing',['events'=>$events]);
    }
    public function completedEvent()
    {
        $events =  Event::where('event_status',2)->get();
        return view('admin.events.completed',['events'=>$events]);
    }
    public function upcomingEvent()
    {
        $events =  Event::where('event_status',3)->get();
        return view('admin.events.upcoming',['events'=>$events]);
    }
    public function cancaledEvent()
    {
        $events =  Event::where('event_status',4)->get();
        return view('admin.events.cancaled',['events'=>$events]);
    }
    public function details($id)
    {
        $events=Event::where('id',$id)->get();
        return view('admin.events.details',['events'=>$events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveEvent(Request $request)
    {
        $data = $request->input();
        $file_name = NULL;
        if($file_data = $request->file('location_images')){
            $file_name = $file_data->getClientOriginalName();
            Storage::disk('public')->put($file_name, File::get($file_data));
        }
        if($file_data){
              $SaveEvent = Event::create([
                'host_id' => $data['host_id'],
                'name' => $data['name'],
                'game_profile' => $data['game_profile'],
                'game_type' => $data['game_type'],
                'event_status' => $data['event_status'],
                'amount_purchase' => $data['amount_purchase'],
                'no_of_re_buy' => $data['no_of_re_buy'],
                'max_player_per_table' => $data['max_player_per_table'],
                'min_player_per_table' => $data['min_player_per_table'],
                'available_seats' => $data['available_seats'],
                'table_rules' => $data['table_rules'],
                'small_blind' => $data['small_blind'],
                'big_blind' => $data['big_blind'],
                'max_buy_in' => $data['max_buy_in'],
                'min_buy_in' => $data['min_buy_in'],
                'game_date' => $data['game_date'],
                'game_time' => $data['game_time'],
                'game_start_time' => $data['game_start_time'],
                'game_end_time' => $data['game_end_time'],
                'location_images' => $file_name,
                'location_latitude' => $data['location_latitude'],
                'location_longitude' => $data['location_longitude'],
                'location_name' => $data['location_name'],
                ]);
                $eventStatus = $data['event_status'];
            if($SaveEvent && $eventStatus == "1" )
            {
                return redirect(action("EventController@ongoingEvent"))->with("flash_message_success","Record Save Successfully");
            }
            elseif($SaveEvent && $eventStatus == "2" )
            {
                return redirect(action("EventController@completedEvent"))->with("flash_message_success","Record Save Successfully");
            }
            elseif($SaveEvent && $eventStatus == "3" )
            {
                return redirect(action("EventController@upcomingEvent"))->with("flash_message_success","Record Save Successfully");
            }
            elseif($SaveEvent && $eventStatus == "4" )
            {
                return redirect(action("EventController@cancaledEvent"))->with("flash_message_success","Record Save Successfully");
            }
        }
        else{
            return redirect(action("EventController@index"))->with("flash_message_error","Don't saved event");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function editEvent($id)
    {
        $events=Event::where('id',$id)->first();
        return view('admin.events.edit',['events'=>$events]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function updateEvent(Request $request, Event $event, $id)
    {
        $data = $request->input();
        $file_name = NULL;
        if($file_data = $request->file('location_images')){
            $file_name = $file_data->getClientOriginalName();
            Storage::disk('public')->put($file_name, File::get($file_data));
        }
        if($file_data){
            $update = Event::where('id', $id)->update([
                'host_id' => $data['host_id'],
                'name' => $data['name'],
                'game_profile' => $data['game_profile'],
                'game_type' => $data['game_type'],
                'event_status' => $data['event_status'],
                'amount_purchase' => $data['amount_purchase'],
                'no_of_re_buy' => $data['no_of_re_buy'],
                'max_player_per_table' => $data['max_player_per_table'],
                'min_player_per_table' => $data['min_player_per_table'],
                'available_seats' => $data['available_seats'],
                'table_rules' => $data['table_rules'],
                'small_blind' => $data['small_blind'],
                'big_blind' => $data['big_blind'],
                'max_buy_in' => $data['max_buy_in'],
                'min_buy_in' => $data['min_buy_in'],
                'game_date' => $data['game_date'],
                'game_time' => $data['game_time'],
                'game_start_time' => $data['game_start_time'],
                'game_end_time' => $data['game_end_time'],
                'location_images' => $file_name,
                'location_latitude' => $data['location_latitude'],
                'location_longitude' => $data['location_longitude'],
                'location_name' => $data['location_name'],
            ]);
            $eventStatus = $data['event_status'];
            if($update && $eventStatus == "1" )
            {
                return redirect(action("EventController@ongoingEvent"))->with("flash_message_success","Record Update Successfully");
            }
            elseif($update && $eventStatus == "2" )
            {
                return redirect(action("EventController@completedEvent"))->with("flash_message_success","Record Update Successfully");
            }
            elseif($update && $eventStatus == "3" )
            {
                return redirect(action("EventController@upcomingEvent"))->with("flash_message_success","Record Update Successfully");
            }
            elseif($update && $eventStatus == "4" )
            {
                return redirect(action("EventController@cancaledEvent"))->with("flash_message_success","Record Update Successfully");
            }
            
        }
        else{
               return redirect(action("EventController@index"))->with("flash_message_success","Don't saved event");
            }
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function deleteEvent($id) {
        Event::find($id)->delete();
        return redirect()->back()->with("flash_message_success","Record Deleted Successfully");
    }
}
