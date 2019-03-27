<?php

namespace App\Services;


use App\FCMDevice;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class PushNotificationService {

    public function send($tokens,$notification){

        if(sizeof($tokens) > 0){

            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60*20);

            $notificationBuilder = new PayloadNotificationBuilder($notification['title']);
            $notificationBuilder->setBody($notification['body'])
                ->setSound('default');


            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData($notification['payload']);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();


            $dsr = FCM::sendTo($tokens, $option, $notification, $data);

            $success = $dsr->numberSuccess();
            $failed = $dsr->numberFailure();
            $modifications = $dsr->numberModification();

            //return Array - you must remove all this tokens in your database
            $deleteArray = $dsr->tokensToDelete();

            FCMDevice::whereIn('token',$deleteArray)->delete();

            //return Array (key : oldToken, value : new token - you must change the token in your database )
            $changeArray = $dsr->tokensToModify();


            foreach ($changeArray as $key => $value){
                FCMDevice::where('token',$key)->update([
                    'token' => $value
                ]);
            }

            // can be used latter

            //return Array - you should try to resend the message to the tokens in the array
            $resendArray = $dsr->tokensToRetry();
            // return Array (key:token, value:errror) - in production you should remove from your database the tokens present in this array
            $errorTokens = $dsr->tokensWithError();


        }

        return [
            'success' => $success,
            'failed' => $failed,
            'modifications' => $modifications
        ];

    }

}