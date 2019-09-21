<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Deposit extends Model
{
    //

    public function users()
    {
        return $this->belongsTo('App\User');
    }

}
