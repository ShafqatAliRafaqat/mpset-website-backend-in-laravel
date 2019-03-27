<?php
namespace App\Services;

use App\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class EventService extends Service {

    public function all(){
        $qb = $this->getQB();
        return $qb->get();
    }

    public function find($where) {
        $event = Event::where($where)
        ->with('location.images', 'host', 'users')
        ->first();

        if (!$event) {
            abort(400, "Event Does not exists");
        }

        return $event;
    }

    public function create($data){

        $this->validate($data);

        $locationService = new LocationService();

        $locationData = $data['location'];

        $location = $locationService->create($locationData);

        $data['location_id'] = $location->id;


        $event = Event::create($this->getSecureInput($data));

        $user_events = [];

        if (isset($data['users'])) {
            $users = $data['users'];
            foreach ($users as $user_id) {
                $user_events[] = [
                    'user_id' => $user_id,
                    'event_id' => $event->id,
                    'isApproved' => $user_id == $data['host_id'],
                ];
            }
        }

        DB::table('user_event')->insert($user_events);

        return $event;
    }

    public function update($id,$data){

        $event = $this->find([
            ['id' => $id]
        ]);

        $data['location_id'] = $event->location->id;

        $event->update($this->getSecureInput($data));

        return $event;
    }

    public function allWithPagination(){
        $qb = $this->getQB();
        return $qb->paginate();
    }

    private function getQB(){
        $qb = Event::orderBy('updated_at', 'DESC');
        return $qb;
    }

    public function delete($where){
        return Event::where($where)->delete();
    }

    public function getSecureInput($input){

        $data = [
            'host_id' => $input['host_id'],
            'name' => $input['name'],
            'game_profile' => $input['game_profile'],
            'game_type' => $input['game_type'],
            'isPrivate' => $input['isPrivate'],
            'max_players' => $input['max_players'],
            'min_players' => $input['min_players'],
            'table_rules' => $input['table_rules'],
            'game_date' => Carbon::parse($input['game_date']),
            'status' => $input['status'],
            'location_id' => $input['location_id']
        ];

        if (in_array($input['game_type'], [Event::$CASH, Event::$BOTH])) {
            $data = array_merge($data, [
                'purchase_amount' => $input['purchase_amount'],
                're_buyins' => $input['re_buyins']
            ]);
        }

        if (in_array($input['game_type'], [Event::$TOURNAMENT, Event::$BOTH])) {
            $data = array_merge($data, [
                'small_blind' => $input['small_blind'],
                'big_blind' => $input['big_blind'],
                'max_buyins' => $input['max_buyins'],
                'min_buyins' => $input['min_buyins'],
            ]);
        }

        if ($input['isPrivate']) {
            $data = array_merge($data, [
                'votingEnabled' => $input['votingEnabled'],
                'valid_start_date' => Carbon::parse($input['valid_start_date']),
                'valid_end_date' => Carbon::parse($input['valid_end_date']),
            ]);
        }

        return $data;

    }

    public function validate($input) {

        $rules = [
            'name' => 'required',
            'game_profile' => 'required',
            'game_type' => 'required',
            'isPrivate' => 'required',
            'max_players' => 'required|numeric',
            'min_players' => 'required|numeric',
            'table_rules' => 'required',
            'game_date' => 'required',
            'location' => 'required',

        ];

        if(in_array($input['game_type'],[Event::$CASH,Event::$BOTH])){
            $rules = array_merge($rules,[
                'purchase_amount' => 'required|numeric',
                're_buyins' => 'required|numeric'
            ]);
        }


        if(in_array($input['game_type'],[Event::$TOURNAMENT,Event::$BOTH])){
            $rules = array_merge($rules,[
                'small_blind' => 'required|numeric',
                'big_blind' => 'required|numeric',
                'max_buyins' => 'required|numeric',
                'min_buyins' => 'required|numeric',
            ]);
        }

        if($input['isPrivate']){
            $rules = array_merge($rules,[
                'votingEnabled' => 'required',
                'valid_start_date' => 'required',
                'valid_end_date' => 'required',
                'users' => 'required',
            ]);
        }

        $this->validateOrAbort($input,$rules);
    }

}
