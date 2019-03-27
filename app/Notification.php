<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

    public static $GENERAL = 'general';
    public static $FRIEND = 'friend';
    public static $EVENT = 'event';

    public static $TYPES = [
        'general' => 'General',
        'friend' => 'Friend',
        'event' => 'Event',
    ];

    protected $guarded  = [
        'id'
    ];

    public function users(){
        return $this->belongsToMany('App\User','user_notification','notification_id','user_id')
            ->withPivot('isRead');
    }

}
