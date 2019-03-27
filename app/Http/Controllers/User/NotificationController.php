<?php
use App\User;
namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\UserResource;

class NotificationController extends Controller
{

    public function index()
    {

        $auth = Auth::user();
        $user = User::where('id',$auth->id)->with('userDetail')->first();
        $notifications = $auth->notifications()->paginate();

        return NotificationResource::collection([
            'notifications' => $notifications,
            'user' => $user
        ]);
    }

}
