<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transaction;
use App\Address;
use App\Subscribe;

class UserlogController extends Controller
{
	 public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
    	return view('admin.user.users', compact('users'));
    }

    public function userSearch(Request $request)
    {
        $this->validate($request,
            [
                'search' => 'required',
            ]);

        $users = User::where('username', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%')->orWhere('name', 'like', '%' . $request->search . '%')->get();

        return view('admin.user.search', compact('users'));

    }

    public function single($id)
    {
        $user = User::findorFail($id);
    	$balance = Address::where('user_id', $user->id)->sum('balance');
        $trans = Transaction::where('user_id', $user->id)->paginate(10);
    	return view('admin.user.single', compact('user','trans','balance'));
    }

    public function transactions()
    {
        $trans = Transaction::orderBy('id', 'desc')->paginate(10);
        return view('admin.user.translog', compact('trans'));
    }

    public function email($id)
    {
        $user = User::findorFail($id);
        return view('admin.user.email',compact('user'));
    }

    public function sendemail(Request $request)
    {
         $this->validate($request,
            [
                'emailto' => 'required|email',
                'reciver' => 'required',
                'subject' => 'required',
                'emailMessage' => 'required'
            ]);
         $to = $request->emailto;
         $name = $request->reciver;
         $subject = $request->subject;
         $message = $request->emailMessage;

         send_email($to, $name, $subject, $message);

        return back()->withSuccess('Mail Sent Successfuly');

    }


    public function subscribers()
    {
        $subs = Subscribe::all();
        return view('admin.user.subscribers', compact('subs'));
    }

    public function subsEmail(Request $request)
    {
        $this->validate($request,
            [
                'subject' => 'required',
                'emailMessage' => 'required'
            ]);

        $subs = Subscribe::all();

        foreach ($subs as $user)
        {

         $to = $user->email;
         $name = $user->name;
         $subject = $request->subject;
         $message = $request->emailMessage;

         send_email($to, $name, $subject, $message);
        }

        return back()->withSuccess('Mail Sent Successfuly');
    } 

    public function broadcast()
    {
        return view('admin.user.broadcast');
    }

    public function broadcastemail(Request $request)
    {
        $this->validate($request,
            [
                'subject' => 'required',
                'emailMessage' => 'required'
            ]);

        $users = User::where('status', '1')->get();

        foreach ($users as $user)
        {

         $to = $user->email;
         $name = $user->name;
         $subject = $request->subject;
         $message = $request->emailMessage;

         send_email($to, $name, $subject, $message);
        }

        return back()->withSuccess('Mail Sent Successfuly');
    }

    
     public function userPasschange(Request $request,$id)
    {
         $user = User::find($id);

        $this->validate($request,
            [
            'password' => 'required|string|min:6|confirmed'
            ]);
        if($request->password == $request->password_confirmation)
            {
                $user->password = bcrypt($request->password);
                $user->save();

                $msg =  'Password Changed By Admin. New Password is: '.$request->password;
                send_email($user->email, $user->username, 'Password Changed', $msg);
                $sms =  'Password Changed By Admin. New Password is: '.$request->password;
                send_sms($user->mobile, $sms);

                return back()->with('success', 'Password Changed');
            }
            else 
            {
                return back()->with('alert', 'Password Not Matched');
            }
    }

   
    public function statupdate(Request $request,$id)
    {
        $user = User::find($id);

        $this->validate($request,
            [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            ]);

        $user['name'] = $request->name ;
        $user['mobile'] = $request->mobile;
        $user['email'] = $request->email;
        $user['status'] = $request->status =="1" ?1:0;
        $user['emailv'] = $request->emailv =="1" ?1:0;
        $user['smsv'] = $request->smsv =="1" ?1:0;
        $user['tauth'] = $request->tauth =="1" ?1:0;

        $user->save();

        $msg =  'Your Profile Updated by Admin';
        send_email($user->email, $user->username, 'Profile Updated', $msg);
        $sms =  'Your Profile Updated by Admin';
        send_sms($user->mobile, $sms);

        return back()->withSuccess('User Profile Updated Successfuly');
    }

    public function banusers()
    {
        $users = User::where('status', '0')->orderBy('id', 'desc')->paginate(10);
        return view('admin.user.banned', compact('users'));
    }

}
