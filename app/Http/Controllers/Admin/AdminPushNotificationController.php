<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\NotificationHelper;
use App\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPushNotificationController extends Controller {


    public function send(Request $request){

        $input = $request->all();

        $this->validateOrAbort($input,[
            'notification' => 'required'
        ]);

        $notification  = $input['notification'];

        $notification['payload'] = array_merge($notification['payload'],[
            'type' => Notification::$GENERAL
        ]);


        $data = NotificationHelper::GENERATE($notification,$request->users);

        return [
            'message' => 'Notification Sent Successfully',
            'data' => $data,
        ];

    }

}
