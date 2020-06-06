<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input as input;
use App\Lib\GoogleAuthenticator;
use Exeption;
use App\Lib\BlockIo;
use App\User;
use App\General;
use App\Address;
use App\Transaction;
use Auth;
use Hash;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','ckstatus']);
    }

    public function index()
    { 

      $adds = Address::where('user_id', Auth::id())->orderBy('id', 'desc')->take(5)->get();
      $sendad = Address::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
      $btcbal = Address::where('user_id', Auth::id())->sum('balance');
      $trans = Transaction::where('user_id', Auth::id())->orderBy('time', 'desc')->paginate(10);

      return view('user.home',compact('adds', 'btcbal', 'trans','sendad'));
    }

    public function refered()
    {
      $refers = User::where('refid', Auth::id())->paginate(10);

      return view('user.refer', compact('refers'));
    }

    public function transactions()
    {
       $trans = Transaction::where('user_id', Auth::id())->orderBy('time', 'desc')->paginate(10);

      return view('user.trans', compact('trans'));
    }
    public function tranFee(Request $request)
    {

       $gnl = General::first();

        $apiKey = $gnl->blockapi;
        $version = 2; 
        $pin =  $gnl->blockpin;
        $block_io = new BlockIo($apiKey, $pin, $version);
      
      $fee = $block_io->get_network_fee_estimate(array('amounts' => $request->amount, 'to_addresses' => $request->toid));
      $tranfee = $fee->data->estimated_network_fee;
  
       return  $tranfee;
    
    }

    public function receiveBtc(Request $request)
    {

      $valid = Address::findOrFail($request->toacc);
     
      if ($valid != null && $valid->user_id == Auth::id()) 
      {
           $varb = "bitcoin:".$valid->address."?amount=".$request->btcamount;
           $bcode['code'] = $varb;
           $bcode['qcode'] =  "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8\" title='' style='width:300px;' />";
           return $bcode; 
      } 
      else
      {
        return back()->with('alert', 'This is Not Your BTC Wallet Address');
      }
   }

    public function sendMoney(Request $request)
    {
       $this->validate($request,
            [
                'fromad' => 'required',
                'toid' => 'required',
                'amount' => 'required',
            ]);
            
      $valid = Address::findOrFail($request->fromad);

      if ($valid != null && $valid->user_id == Auth::id()) 
      {
         $gnl = General::first();

        $apiKey = $gnl->blockapi;
        $version = 2; 
        $pin =  $gnl->blockpin;
        $block_io = new BlockIo($apiKey, $pin, $version);
        
                   $user = User::find(Auth::id());
        if ($valid->balance <  $request->amount) 
        {
          return back()->with('alert', 'Insufficient Balance');
        }
        
        $fee = $block_io->get_network_fee_estimate(array('amounts' => $request->amount, 'to_addresses' => $request->toid));

        $tranfee = $fee->data->estimated_network_fee;

        $total =  $tranfee + $request->amount;

        
        if ($valid->balance < $total) 
        {
          return back()->with('alert', 'Insufficient Balance');
        }
        else
        {
          $block_io->withdraw_from_addresses(array('amounts' => $request->amount, 'from_addresses' =>  $valid->address, 'to_addresses' => $request->toid));
          $user = User::findOrFail(Auth::id());       
	         $msg =  "$request->amount BTC Sent Successfully to $request->toid";
          send_email($user->email, $user->username, 'Sent', $msg);
          send_sms($user->mobile, $msg);
        
          return back()->with('success', 'BTC Send Successfully');
        }
      }
      else
      {
        return back()->with('alert', 'This is Not Your BTC Wallet Address');
      }
     
    }

    public function allAddress()
    { 
      $adds = Address::where('user_id', Auth::id())->paginate(10);

      return view('user.alladds',compact('adds'));
    }

    public function google2fa()
    {
        $gnl = General::first();
        $ga = new GoogleAuthenticator();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl(Auth::user()->username.'@'.$gnl->title, $secret);

        $prevcode = Auth::user()->secretcode;
        $prevqr = $ga->getQRCodeGoogleUrl(Auth::user()->username.'@'.$gnl->title, $prevcode);

        return view('user.goauth.create', compact('secret','qrCodeUrl','prevcode','prevqr'));
    }

    public function create2fa(Request $request)
    {
        $user = User::find(Auth::id());
        
        $this->validate($request,
            [
                'key' => 'required',
                'code' => 'required',
            ]);

        $ga = new GoogleAuthenticator();

        $secret = $request->key;
        $oneCode = $ga->getCode($secret); 
        $userCode = $request->code;

        if ($oneCode == $userCode) 
        { 
            $user['secretcode'] = $request->key;
            $user['tauth'] = 1;
            $user['tfver'] = 1;
            $user->save();

            $msg =  'Google Two Factor Authentication Enabled Successfully';
            send_email($user->email, $user->username, 'Google 2FA', $msg);
            $sms =  'Google Two Factor Authentication Enabled Successfully';
            send_sms($user->mobile, $sms);

            return back()->with('success', 'Google Authenticator Enabeled Successfully');
        }
        else 
        {

            return back()->with('alert', 'Wrong Verification Code');
        }
       
    }

    public function disable2fa(Request $request)
    {
      $this->validate($request,
        [
            'code' => 'required',
        ]);

      $user = User::find(Auth::id());
      $ga = new GoogleAuthenticator();

      $secret = $user->secretcode;
      $oneCode = $ga->getCode($secret); 
      $userCode = $request->code;

      if ($oneCode == $userCode) 
      { 
        $user = User::find(Auth::id());
        $user['tauth'] = 0;
        $user['tfver'] = 1;
        $user['secretcode'] = '0';
        $user->save();

        $msg =  'Google Two Factor Authentication Disabled Successfully';
        send_email($user->email, $user->username, 'Google 2FA', $msg);
        $sms =  'Google Two Factor Authentication Disabled Successfully';
        send_sms($user->mobile, $sms);

        return back()->with('success', 'Two Factor Authenticator Disable Successfully');
      } 
      else 
      {
        return back()->with('alert', 'Wrong Verification Code');
      }
       
    }

    //Change password
    public function changepass()
    {
      $user = User::find(Auth::id());
      return view('auth.changepass', compact('user'));
    }

    public function chnpass()
    {
      $user = User::find(Auth::id());

      if(Hash::check(Input::get('passwordold'), $user['password']) && Input::get('password') == Input::get('password_confirmation'))
      {
        $user->password = bcrypt(Input::get('password'));
        $user->save();

        $msg =  'Password Changed Successfully';
        send_email($user->email, $user->username, 'Password Changed', $msg);
        $sms =  'Password Changed Successfully';
        send_sms($user->mobile, $sms);

        return back()->with('success', 'Password Changed');
      }
      else 
      {
          return back()->with('alert', 'Password Not Changed');
      }
    }

     public function createAddress(Request $request)
    {
       $gnl = General::first();
        $apiKey = $gnl->blockapi;
        $version = 2; // API version
        $pin =  $gnl->blockpin;
        $block_io = new BlockIo($apiKey, $pin, $version);
        $ad = $block_io->get_new_address();

        if ($ad->status == 'success') 
        {
          $data = $ad->data;

          $add['user_id'] = Auth::id();
          $add['label'] = $request->label;
          $add['address'] = $data->address;
          $add['balance'] = '00';

          Address::create($add);
                     $user = User::find(Auth::id());
        $msg =  'New Address Created Successfully';
        send_email($user->email, $user->username, 'New Address', $msg);
        send_sms($user->mobile, $msg);

          return back()->with('success', 'New Address Created Succesfully');

        }
        else
        {
          return back()->with('alert', 'Failed to Create New Address');

        }
    }

  }
