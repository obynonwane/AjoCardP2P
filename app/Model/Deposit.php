<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Deposit extends Model
{
    //
    protected $fillable = ['amount_deposited','user_id','deposit_reference','status'];

    public function users()
    {
        return $this->belongsTo('App\User');
    }

}
