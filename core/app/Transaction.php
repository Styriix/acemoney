<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
     protected $table = 'transactions';
    protected $fillable = array( 'user_id','type','time', 'recipient', 'sender', 'amount', 'confirmations', 'txid');

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
