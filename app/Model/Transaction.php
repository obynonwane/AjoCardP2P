<?php

namespace App\Model;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
