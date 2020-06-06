<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function logout(Request $request)
    {
        $logg = User::findOrFail(Auth::user()->id);

        if(Auth::user()->tauth==1){
            $logg['tfver'] = 0;
        }else{
            $logg['tfver'] = 1;
        }
        $logg->save();

        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
