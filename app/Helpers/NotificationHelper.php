<?php

namespace App\Helpers;


use App\FCMDevice;
use App\Notification;
use App\Services\PushNotificationService;
use App\User;

class NotificationHelper {


    public static function GENERATE($notification,$users){

//        $not = Notification::create([
//            'title' => $notification['title'],
//            'body' => $notification['body'],
//            'payload' => json_encode($notification['payload']),
//        ]);
//
//        if(isset($users)){
//            $not->users()->sync($users);
//        }
//
//        // if users are set on request it will send notifications to selected users otherwise it will
//        // send notifications to all users
//
//        $ids = User::whereHas('userDetail',function ($qb){
//            $qb->where('notification_status',1);
//        })->when(isset($users), function ($qb) use($users) {
//            $qb->whereIn('id',$users);
//        })->pluck('id')->toArray();
//
//
//        $tokens = FCMDevice::whereIn('user_id',$ids)->pluck('token')->toArray();
//
//        $service = new PushNotificationService();
//
//        $data = $service->send($tokens,$notification);
//
//        return $data;

    }

}