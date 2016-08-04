<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requester extends Model
{
    protected $table = 'request';

    function user()
    {
        return $this->belongsTo('App\User', 'requester_id');
    }

    function recipient()
    {
        return $this->belongsTo('App\User', 'recipient_id');
    }

    function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }
}
