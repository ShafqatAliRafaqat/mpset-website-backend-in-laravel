<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class EventFilter extends Model
{
    protected $guarded  = [
        'id'
    ];
    public function reviews(){
        return $this->hasMany('App\Review');
    }
    public function users(){
        return $this->belongsToMany('App\User');
    }
}
