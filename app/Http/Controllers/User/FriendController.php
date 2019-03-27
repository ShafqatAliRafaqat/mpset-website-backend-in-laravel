<?php

namespace App\Http\Controllers\User;

use App\Helpers\NotificationHelper;
use App\Notification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersResource;
use App\Event;
use App\Http\Resources\LocationsResource;
use App\Review;

class FriendController extends Controller {

    public function getFriends(){

        $first = DB::table('friends')
            ->leftJoin('users', 'users.id', '=', 'friends.friend_id')
            ->select('users.*')
            ->where('friends.user_id', Auth::user()->id)
            ->where('friends.isApproved', 1);

        $friends = DB::table('friends')
            ->leftJoin('users', 'users.id', '=', 'friends.user_id')
            ->select('users.*')
            ->where('friends.friend_id', Auth::user()->id)
            ->where('friends.isApproved', 1)
            ->union($first)
            ->get();

        return UsersResource::collection($friends);
    }

    public function details($local,$id){
        
        $user = User::where('id',$id)->with('userDetail','location')->first();
        
        if(!$user){
            abort(400,'User Does not exists');
        }

        $playedEvents = $user->events()->where('status',Event::$COMPLETED)->count();
        
        $played_time = Event::GET_PLAYED_TIME($user->id);
        
        $player_rating = Review::GET_PLAYER_RATING($user->id);
        $host_rating = Review::GET_HOST_RATING($user->id);

        $location_rating = 0;

        if($user->location){
            $location_rating = Review::GET_LOCATION_RATING($user->location->id);
        }
        
        return UserResource::make($user)->additional(['meta' => [
            'played_events' => $playedEvents,
            'played_time' => $played_time,
            'player_rating' => $player_rating,
            'host_rating' => $host_rating,
            'location_rating' =>$location_rating,
            'location' => ($user->location)? LocationsResource::make($user->location):null
        ]]);
    }

    public function getUsersWithFriendshipStatus() {

        $id = Auth::user()->id;

        $sql = "SELECT * from 
        ( 
            SELECT u.*,f.user_id,f.friend_id,f.isApproved FROM `users` u 
            LEFT JOIN friends f on f.friend_id=u.id 
            where u.id!=$id AND ( f.friend_id=$id or f.user_id=$id or f.friend_id is null or f.user_id is null) 
            UNION 
            SELECT u.*,f.user_id,f.friend_id,f.isApproved FROM `users` u 
            LEFT JOIN friends f on f.user_id=u.id 
            where u.id!=$id AND ( f.friend_id=$id or f.user_id=$id or f.friend_id is null or f.user_id is null) 
        ) t ORDER by t.isApproved DESC";

        $records = DB::select($sql);
        
        $users =  [];

        $host = env('APP_URL','http://localhost:8000');

        foreach($records as $record){
            $record->friendshipStatus = $this->getFriendsipStatus($record,$id);
            $record->avatar = ($record->avatar)?"$host/$record->avatar":"$host/defaults/avatar/avatar.png";
            
            if(!$this->userExists($users,$record)){
                $users[] = $record;
            }
        }

        return $users;

    }

    private function userExists($users,$user){
        foreach($users as $u){
            if($u->id == $user->id){
                return true;
            }
        }

        return false;
    }

    public function removeFriend($local, $id) {
        
        $user_id = Auth::user()->id;

        DB::table('friends')->where([
            ['user_id', $user_id],
            ['friend_id', $id],
        ])->delete();

        DB::table('friends')->where([
            ['user_id', $id],
            ['friend_id', $user_id],
        ])->delete();

        return [
            'message' => "Friend Removed Successfully"
        ];
    }

    public function addFriend($local, $id){

        $user = Auth::user();

        $user_id = $user->id;
        
        $exists = DB::table('friends')->where([
            ['user_id', $id],
            ['friend_id', $user_id],
        ])->exists();

        if($exists){
            abort(400,'Already Friend');
        }

        $exists = DB::table('friends')->where([
            ['friend_id', $id],
            ['user_id', $user_id],
        ])->exists();

        if($exists){
            abort(400,'Already Friend');
        }


        DB::table('friends')->insert([
            'user_id' => $id,
            'friend_id' => $user_id,
        ]);


        NotificationHelper::GENERATE([
            'title' => 'New Friend Request',
            'body' => "$user->first_name  $user->last_name added you as friend",
            'payload' => [
                'type' => Notification::$FRIEND
            ]
        ],[$id]);


        return [
            'message' => "Friend Added Successfully"
        ];

    }

    public function cancelRequest($local, $id){
        
        $user_id = Auth::user()->id;
        
        DB::table('friends')->where([
            ['user_id', $id],
            ['friend_id', $user_id],
        ])->delete();

        return [
            'message' => "Request Canceled Successfully"
        ];
    }

    public function declineRequest($local, $id){
        
        $user_id = Auth::user()->id;
        
        DB::table('friends')->where([
            ['user_id', $user_id],
            ['friend_id', $id],
        ])->delete();

        return [
            'message' => "Request Declined Successfully"
        ];
    }

    public function acceptRequest($local, $id){
        
        $user = Auth::user();
        
        DB::table('friends')->where([
            ['user_id', $user->id],
            ['friend_id', $id],
        ])->update([
            'isApproved' => 1
        ]);

        NotificationHelper::GENERATE([
            'title' => 'Friend Request Approved',
            'body' => "$user->first_name  $user->last_name approved your fiend request",
            'payload' => [
                'type' => Notification::$FRIEND
            ]
        ],[$id]);

        return [
            'message' => "Request Accepted Successfully"
        ];
    }

    private function getFriendsipStatus($user,$id){

        if($user->user_id == null && $user->friend_id == null){
            return "not_friend";
        }

        if($user->user_id && $user->friend_id && $user->isApproved == 1){
            return "already_friend";
        }

        if($user->isApproved == 0 && $user->user_id == $id){
            return "requested_friendsip";
        }

        if($user->isApproved == 0 && $user->friend_id == $id){
            return "pending_acceptance";
        }
    }
}
