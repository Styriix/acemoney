<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','username','mobile','tauth','tfver','status','emailv','smsv','vsent','vercode','secretcode','refid'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    

    public function transaction()
    {
        return $this->hasMany('App\Transaction','id','user_id');
    }
    public function address()
    {
        return $this->hasMany('App\Address','id','user_id');
    }
}
