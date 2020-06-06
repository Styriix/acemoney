<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    protected $fillable = array( 'user_id','label', 'address', 'balance','pendingbalance');
   
   public function user()
    {
        return $this->belongsTo('App\User');
    }
}
