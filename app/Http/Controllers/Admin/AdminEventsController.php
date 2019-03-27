<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventsResource;
use App\Http\Resources\EventDetailResource;
use App\Review;
use Illuminate\Support\Facades\Auth;

class AdminEventsController extends Controller
{

    /** @var EventService */
    private $service;

    public function __construct()
    {
        $this->service = new EventService();
    }

    public function index()
    {
        $events = $this->service->allWithPagination();
        return EventsResource::collection($events);
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

    public function update($local,$id,Request $request){

        $input = $request->all();

        $input['host_id'] = Auth()->user()->id;

        $event = $this->service->update($id,$input);

        return [
            'message' => 'Event updated Successfully',
            'data' => EventsResource::make($event)
        ];
    }

    public function details($local, $id){

        $event = $this->service->find([
            ['id', $id]
        ]);

        $event->rating = Review::GET_EVENT_RATING($id);

        $users = $event->users;

        foreach ($users as $user) {
            $user->rating = Review::GET_PLAYER_RATING($user->id);
        }

        return EventDetailResource::make($event);
    }

    public function destroy($local, $id)
    {

        $this->service->delete([
            ['id', $id]
        ]);

        return [
            'message' => 'Event Deleted Successfully'
        ];
    }
}
