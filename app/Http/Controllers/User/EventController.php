<?php

namespace App\Http\Controllers\User;

use App\Event;

use App\Helpers\NotificationHelper;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventsResource;
use App\Http\Resources\EventDetailResource;

class EventController extends Controller {

    /** @var EventService */
    private $service;


    /**
     * EventController constructor.
     */
    public function __construct()
    {
        $this->service = new EventService();
    }
    
    public function eventStats() {

        $user = Auth()->user();

        $status = Event::GET_EVENT_STATS($user->id);
        $locationStats = Event::GET_EVENT_AND_LOCATION_STATS($user->id);

        $eventHistory = $this->history();

        return [
            'data' => [
                'minutes' => ($status->minutes)?$status->minutes:0,
                'no_of_events' => ($status->no_of_events)?$status->no_of_events:0,
                'buyins' => ($status->buyins)?$status->buyins:0,
                'checkout' => ($status->checkout)?$status->checkout:0,
                'balance' => 0, // to do
                'cashGame_balance' => 0, // to do
                'tournament_balance' => 0, // to do,
                'location_events' => $locationStats,
                'events' => $eventHistory
            ]
        ];

    }

    public function upcoming()
    {

        $events = Event::select('events.*', 'user_event.user_id', 'user_event.event_id')
            ->with('location', 'host')
            ->leftJoin('user_event', 'events.id', '=', 'user_event.event_id')
            ->where('user_event.user_id', '!=', Auth::user()->id)
            ->WhereNotNull('user_event.user_id')
            ->where('events.isPrivate', 0)
            ->where('events.game_date', '>', Carbon::now())
            ->groupby('events.id')->orderby('events.game_date')
            ->paginate();

        return EventsResource::collection($events);
    }

    public function pending()
    {

        $user = Auth::user();

        $events = $user->events()
            ->wherePivot('isApproved', 0)
            ->wherePivot('isCanceled', 0)
            ->groupBy('events.id')->paginate();

        return EventsResource::collection($events);
    }

    public function attending()
    {

        $user = Auth::user();

        $events = $user->events()
            ->wherePivot('isApproved', 1)
            ->wherePivot('isCanceled', 0)
            ->whereIn('status', [Event::$NOT_STARTED, Event::$PENDING_VOTING, Event::$VOTING_FINALIZED])
            ->groupBy('events.id')->paginate();

        $inProgress = $user->events()
            ->wherePivot('isApproved', 1)
            ->wherePivot('isCanceled', 0)
            ->whereIn('status', [Event::$STARTED])
            ->groupBy('events.id')->get();

        return EventsResource::collection($events)->additional(['meta' => [
            'inProgress' => EventsResource::collection($inProgress),
        ]]);
    }

    public function cancelEvent($local, $id)
    {

        $user = Auth::user();

        $event = Event::where('id',$id)->with('host')->first();

        if(!$event){
            abort('404','Event Does not exists');
        }

        $host = $event->host;

        DB::table('user_event')->where([
            ['event_id', $id],
            ['user_id', $user->id],
        ])->update([
            'isCanceled' => 1
        ]);

        NotificationHelper::GENERATE([
            'title' => 'User Canceled Event',
            'body' => "$user->first_name  $user->last_name canceled your event $event->name",
            'payload' => [
                'type' => Notification::$EVENT
            ]
        ],[$host->id]);


        return [
            'message' => "Event Canceled Successfully"
        ];

    }

    public function hosting(){

        $events = Event::where('host_id', Auth::user()->id)
            ->with('host')->orderBy('created_at', 'DESC')->paginate();

        return EventsResource::collection($events);
    }

    public function history(){

        $user = Auth::user();

        $events = $user->events()
            ->whereIn('status', [Event::$CANCELED, Event::$COMPLETED])
            ->orwherePivot('isCanceled', 1)
            ->groupBy('events.id')->get();

        return EventsResource::collection($events);
    }

    public function details($local, $id) {

        $event = $this->service->find([
            ['id', $id]
        ]);

        $event->stats = Event::GET_EVENT_STATS_ByID($id);

        return EventDetailResource::make($event);
    }

    public function placePlayerOnSeat(Request $request){

        $input = $request->all();

        $this->validateOrAbort($input, [
            'event_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'seat_no' => 'required|numeric',
        ]);

        DB::table('user_event')->where([
            ['event_id',$input['event_id']],
            ['user_id',$input['user_id']],
        ])->update([
            'seat_no' => $input['seat_no']
        ]);

        return [
            'message' => 'Player Placed Successfully'
        ];
    }

    public function placeVote(Request $request){

        $input = $request->all();

        $this->validateOrAbort($input, [
            'event_id' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        DB::table('user_event')->where([
            ['event_id',$input['event_id']],
            ['user_id',Auth::user()->id]
        ])->update([
            'start_date' => Carbon::parse($input['start_date']),
            'end_date' => Carbon::parse($input['end_date'])
        ]);

        return [
            'message' => 'Dates Updated Successfully'
        ];
    }

    public function acceptPlayer($local,$id,Request $request){

        $input = $request->all();

        $this->validateOrAbort($input,[
            'user_id' => 'required|numeric'
        ]);

        $event = Event::where([
            ['id',$id],
            ['host_id',Auth::user()->id]
        ])->first();

        if(!$event){
            abort(404,'Event Does not Exists');
        }

        DB::table('user_event')->where([
            ['event_id',$id],
            ['user_id',$input['user_id']],
        ])->update([
            'isApproved' => true,
        ]);

        return [
            'message' => 'Player Approved Successfully'
        ];
    }

    public function removePlayer($local,$id,Request $request){

        $input = $request->all();

        $this->validateOrAbort($input,[
            'user_id' => 'required|numeric'
        ]);

        $event = Event::where([
            ['id',$id],
            ['host_id',Auth::user()->id]
        ])->first();

        if(!$event){
            abort(404,'Event Does not Exists');
        }

        DB::table('user_event')->where([
            ['event_id',$id],
            ['user_id',$input['user_id']],
        ])->delete();

        return [
            'message' => 'Player Removed Successfully'
        ];
    }

    public function updateEvent(Request $request){

        $input = $request->all();

        $this->validateOrAbort($input, [
            'event_id' => 'required|numeric'
        ]);

        $event = Auth::user()->events()->where([
            ['events.id',$input['event_id']]
        ])->first();

        if(!$event){
            abort(404,'Event Does not Exists');
        }

        unset($input['event_id']);

        $data = [];

        if($request->game_date){
            $data['game_date'] = Carbon::parse($input['game_date']);
        }

        $data = array_merge($input,$data);

        $event->update($data);

        return [
            'message' => 'Event Updated Successfully'
        ];

    }

    public function join(Request $request) {

        $input = $request->all();

        $this->validateOrAbort($input, [
            'event_id' => 'required'
        ]);

        $event = Event::where('id',$input['event_id'])->with('host')->first();

        if (!$event) {
            abort(400, "Event Does not exists");
        }

        $host = $event->host;
        $user =  Auth::user();

        DB::table('user_event')->insert([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'isApproved' => false,
        ]);


        NotificationHelper::GENERATE([
            'title' => 'User Joined Event',
            'body' => "$user->first_name  $user->last_name joined your event $event->name",
            'payload' => [
                'type' => Notification::$EVENT
            ]
        ],[$host->id]);


        return [
            'message' => "Event Joined Successfully"
        ];
    }

    public function create(Request $request){

        $input = $request->all();

        $input['status'] = Event::$NOT_STARTED;

        $input['location'] = array_merge($input['location'], [
            'location_user_id' => Auth::user()->id,
            'user_id' => Auth::user()->id,
        ]);

        $input['host_id'] = Auth()->user()->id;

        if (isset($input['users'])) {
            $input['users'] = array_merge($input['users'], [
                Auth::user()->id,
            ]);
        }

        $event = $this->service->create($input);

        return [
            'message' => __('messages.model.create.success', [
                'model' => __('messages.Event')
            ]),
            'data' => EventsResource::make($event)
        ];

    }

}
