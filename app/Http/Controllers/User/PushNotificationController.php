<?php

namespace App\Http\Controllers\User;

use App\FCMDevice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PushNotificationController extends Controller {


    public function register(Request $request){

        $input = $request->all();

        $this->validateOrAbort($input,[
            'token' => 'required',
        ]);

        $user_id = Auth::user()->id;

        $device = FCMDevice::where([
            ['user_id',$user_id],
            ['token',$input['token']],
        ])->first();

        if(!$device){
            FCMDevice::create([
                'user_id' => $user_id,
                'token' => $input['token'],
            ]);
        }

        return [
            'message' => 'Device Registered Successfully'
        ];

    }
}
