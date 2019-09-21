<?php

namespace App\Model;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

    protected $fillable = [
        'sender_id', 
        'receiver_id', 
        'transaction_reference',
        'amount_sent',
        'amount_received',
    ];

    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
