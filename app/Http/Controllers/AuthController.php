<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Company;

class AuthController extends Controller
{
    public function login(Request $request){
      
        $cred= $request->only(["email","password"]);
      if(Auth::attempt($cred)){
        return redirect()->route('landing');
      }
      return redirect('/login')->with('error','Please provide correct credentials...');
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect()->route('login.get');
    }

    public function landing(Request $request){
        $companies=Company::all();
        return view('landing',compact('companies'));
    }
}
