<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

    protected $guarded  = [
        'id'
    ];

    public function user() {
        return $this->hasOne('App\User');
    }

    public function events() {
        return $this->hasMany('App\Event','location_id','id');
    }

    public function images(){
        return $this->hasMany('App\Media','location_id','id');
    }

    public function reviews(){
        return $this->hasMany('App\Review','location_id','id');
    }
}
