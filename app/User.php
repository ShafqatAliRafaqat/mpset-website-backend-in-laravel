<?php

namespace App;

use App\LinkedSocialAccount;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guarded  = [
        'id'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userDetail() {
        return $this->hasOne('App\UserDetail');
    }

    public function location() {
        return $this->hasOne('App\Location','location_user_id','id');
    }

    public function locations() {
        return $this->hasMany('App\Location','user_id','id');
    }

    public function fcmDevices() {
        return $this->hasMany('App\FCMDevice','user_id','id');
    }

    public function linkedSocialAccounts(){
        return $this->hasMany(LinkedSocialAccount::class);
    }

    public function events(){
        return $this->belongsToMany('App\Event','user_event','user_id','event_id')
        ->withPivot('buyins', 'checkout','isApproved','isCanceled','seat_no','start_date','end_date')
    	->withTimestamps();
    }

    public function notifications(){
        return $this->belongsToMany('App\Notification','user_notification','user_id','notification_id')
        ->withPivot('isRead');
    }

    public function EventFilter(){
        return $this->hasMany('App\EventFilter','user_id','id');
    }
    public function reviews(){
        return $this->hasMany('App\Review','user_id','id');
    }

    public function givenReviews(){
        return $this->hasMany('App\Review','reviewer_id','id');
    }

}
