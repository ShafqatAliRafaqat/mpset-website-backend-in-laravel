<?php

namespace App\Http\Controllers\User;

use App\User;
use App\UserDetail;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use App\Services\LocationService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersResource;
use Intervention\Image\Facades\Image;
use App\Http\Resources\LocationResource;

class UserController extends Controller {

    public function getUserDetails(Request $request) {

        $user = Auth::user();

        if (!$user->userDetail) {
            abort(400, "User Details Does not exists");
        }

        return UserResource::make($user);
    }

    public function settings(Request $request){
        
        $input = $request->all();

        $this->validateOrAbort($input, [
            'notification_status' => 'present'
        ]);

        $user = Auth::user();
        
        $user->userDetail->update([
            'notification_status' => $input['notification_status']
        ]);

        return UserResource::make($user);
    }

    public function createOrUpdateUserDetails(Request $request) {

        $input = $request->all();

        $this->validateOrAbort($input, [
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'present'
        ]);

        $user = Auth::user();

        $data = [
            
            'user_id' => $user->id,
            'phone' => $input['phone'],
            'gender' => $input['gender'],
            'address' => $input['address'],
        ];

        $userData = [];

        if ($request->nick_name) {
            $userData['nick_name'] = $request->nick_name;
        }

        if ($request->first_name) {
            $userData['first_name'] = $request->first_name;
        }

        if ($request->last_name) {
            $userData['last_name'] = $request->last_name;
        }


        if ($request->avatar && $request->avatar != "null") {

            $img = Image::make($request->avatar)->resize(300, 300);

            $result = FileHelper::getAndCreatePath($img->filename, 'avatar');

            $extension = substr($img->mime, strpos($img->mime, '/') + 1);

            $result['name'] = $result['name'] . str_random(15) . '.' . $extension;

            $path = $result['path'] . "/" . $result['name'];

            $img->save($path, 60);

            $userData['avatar'] = $path;
        }


        $user->update($userData);


        if ($user->userDetail) {
            $user->userDetail->update($data);
        } else {
            $user->userDetail = UserDetail::create($data);
        }

        return UserResource::make($user);
    }
}
