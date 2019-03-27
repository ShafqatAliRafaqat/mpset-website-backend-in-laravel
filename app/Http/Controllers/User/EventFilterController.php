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
use App\Helpers\QB;
use App\Http\Resources\EventFilterResource;
use App\Http\Resources\EventDetailResource;
use App\EventFilter;

class EventFilterController extends Controller
{
    public function index(Request $request)
    {
        $input = $request->all();
		$user_id = Auth::user()->id;
       
		$qb = EventFilter::where("user_id",$user_id)->orderBy('created_at', 'DESC');
		 
        $qb = QB::where($input, "id", $qb);
        $qb = QB::where($input, "game_type", $qb);
        $qb = QB::where($input, "game_profile", $qb);
        $qb = QB::whereBetween($input, "min_distance", $qb);
        $qb = QB::whereBetween($input, "max_distance", $qb);
        $qb = QB::whereBetween($input, "start_date", $qb);
        $qb = QB::whereBetween($input, "end_date", $qb);
        $qb = QB::where($input, "min_buyins", $qb);
        $qb = QB::where($input, "max_buyins", $qb);

        $eventfilter = $qb->paginate();
        return EventFilterResource::collection($eventfilter);
    }
	public function create(Request $request) {
        
        $data = $request->all();

        $this->validateOrAbort($data, [
            'game_type' => 'required',
            'game_profile' => 'required',
            'min_distance' => 'required',
            'max_distance' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'min_buyins' => 'required',
            'max_buyins' => 'required',
        ]);

        $eventfilter = EventFilter::create([
            'game_type' => $data['game_type'],
            'game_profile' => $data['game_profile'],
            'min_distance' => $data['min_distance'],
            'max_distance' => $data['max_distance'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'min_buyins' => $data['min_buyins'],
            'max_buyins' => $data['max_buyins'],
            'user_id' => Auth::user()->id,
        ]);

        return EventFilterResource::make($eventfilter);
    }
    public function update(Request $request, $id, EventFilter $eventfilter)
    {
		$user_id = Auth::user()->id;
        $eventfilter = EventFilter::where("id", $id)->get();
        if (!$eventfilter) {
            abort(400, 'Event Does not exists');
        }

       $eventfilter= EventFilter::where('id',$id)->first()->update($request->all());

       return EventFilterResource::make($eventfilter);
    }
}
