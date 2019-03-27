<?php

namespace App\Http\Controllers\User;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventsResource;

class TestController extends Controller {

    public function index() {

        return DB::table('friends')
            ->fu('users', 'users.id', '=', 'friends.friend_id')
            ->select('users.*')
            ->where('friends.user_id', Auth::user()->id)
            ->where('friends.isApproved', 1)->get();
    }

}
