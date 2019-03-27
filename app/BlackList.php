<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlackList extends Model {

    protected $guarded  = [
        'id'
    ];

    public static $FEATURES = [
        'payment' => 'Payment',
        'private_event' => 'Private Event',
        'chat' => 'Chat',
    ];

}
