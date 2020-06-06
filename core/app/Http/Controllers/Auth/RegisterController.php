<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\General;
use App\Address;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Lib\BlockIo;

class RegisterController extends Controller
{
   
    use RegistersUsers;

  
    protected $redirectTo = '/home';

 
    public function __construct()
    {
        $this->middleware('guest');
    }

 
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'mobile' => 'required|string',
        ]);
    }

   
    protected function create(array $data)
    {
        $gnl = General::first();

        $apiKey = $gnl->blockapi;
        $version = 2; // API version
        $pin =  $gnl->blockpin;
        $block_io = new BlockIo($apiKey, $pin, $version);
        $ad = $block_io->get_new_address();

        if ($ad->status == 'success') 
        {
          $addata = $ad->data;
          $latuser = User::latest()->first();

          $add['user_id'] =  $latuser->id+1;
          $add['label'] = 'Default Label';
          $add['address'] = $addata->address;
          $add['balance'] = '00';
          Address::create($add);
        }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'mobile' => $data['mobile'],
            'refid' => 0,
            'status' => 1,
            'tauth' => 0,
            'tfver' => 1,
            'docv' => 1,
            'emailv' =>  $gnl->emailver,
            'smsv' =>  $gnl->smsver,
        ]);
    }
}
