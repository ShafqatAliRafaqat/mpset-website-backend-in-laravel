<?php

namespace App\Http\Controllers\Api;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Resources\Event as eventrecource;
use App\Http\Controllers\Controller;

class ApiEventController extends Controller
{
    function __construct()
    {
        return $this->middleware('auth:api');
    }
    public function index(){
        $event=Event::all();
        return eventrecource::collection($event);
    }
    public function show(Event $event){
        return new eventrecource($event);
    }
    
    public function store(Request $request)
    {
        $event=Event::create($request->all());
        return new eventrecource($event);
    }
    public function update(Request $request, Event $event)
    {
        // if($request->user()->id !== $event->user_id){
        //     return response()->json(['error'=>'Unauthorized action'],401);
        // }
          $event->update($request->all());   
          return new eventrecource($event);
    }
    public function destroy(Event $event)
    {
        //  if(request()->user()->id !== $event->user_id){
        //     return response()->json(['error'=>'Unauthorized action'],401);
        // }
         $event=$event->delete();
         return response()->json(null,200);
    }    
}
