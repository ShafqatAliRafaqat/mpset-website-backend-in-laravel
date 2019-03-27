<?php

use Illuminate\Database\Seeder;

use App\Setting;
use Carbon\Carbon;


class SettingTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(){

        $settings = [
            ['key' => 'maximum_seats_per_table','value' => 10],
            ['key' => 'minimum_seats_per_table','value' => 10],
            ['key' => 'home_payment_fee','value' => 10],
            ['key' => 'buy_ins_fee','value' => 10],
            ['key' => 're_buy_ins_fee','value' => 10],
            ['key' => 'default_avatar','value' => "defaults/avatar/avatar.png"],
            ['key' => 'invite_friend_sms_text','value' => "SMS Text"],
            ['key' => 'invite_friend_email_text','value' => "SMS Text"],
            ['key' => 'invitations_per_day','value' => 10],
            ['key' => 'notification_status','value' => 1],
        ];

        foreach ($settings as $setting){
            Setting::create($setting);
        }

    }
}
