<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
      public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function create(Request $request)
    {
        if(Auth::user()->id == 3037){
            if($request->isMethod('GET')){
                return view('user.create');
            }
            if($request->isMethod('POST')){
                $UserName = $request->UserName;
                $password = $request->password;
                $Role = 'User';

                $user = new User();
                $user->UserName = $UserName;
                $user->password = Hash::make($password);
                $user->Role = 'User';
                $user->Status = 1;
                $user->save();

                return redirect()->route('register.user')->with('success','User Register Successfully');
            }
        }else{
            return redirect()->route('home');
        }

    }
}
