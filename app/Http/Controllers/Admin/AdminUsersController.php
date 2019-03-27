<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\EventsResource;
use App\Helpers\QB;

class AdminUsersController extends Controller {
    
    /** @var UserService */
    private $service;

    public function __construct(){
        $this->service = new UserService();
    }

    public function index(Request $request){

        $input = $request->all();

        $qb = $this->service->getQB();

        $qb = QB::whereLike($input, "nick_name", $qb);
        $qb = QB::whereLike($input, "first_name", $qb);
        $qb = QB::whereLike($input, "last_name", $qb);
        $qb = QB::whereLike($input, "email", $qb);

        $users = $qb->paginate();

        return UserResource::collection($users);
    }

    public function create(Request $request){

        $input = $request->all();

        $input['avatar'] = $request->avatar;

        $user = $this->service->create($input);

        return  [
            'message' => 'User Created Successfully',
            'data' => UserResource::make($user)
        ];

    }

    public function update($local,$id,Request $request){
        
        $input = $request->all();

        $input['avatar'] = $request->avatar;

        $user = $this->service->update($id,$input);

        return  [
            'message' => 'User Updated Successfully',
            'data' => UserResource::make($user)
        ];
    }


    public function destroy($local,$id){
        
        $this->service->delete([
            ['id',$id]
        ]);

        return [
            'message' => 'User Deleted Successfully'
        ];
    }

    public function details($local,$id){
        
        $user = $this->service->find([
            ['id',$id]
        ]);

        $events = $user->events()->get();

        return UserResource::make($user)->additional(['meta' => [
            'events' => EventsResource::collection($events),
        ]]);
    }

}
