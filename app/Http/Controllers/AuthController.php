<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Company;

/**
 * Controller for handling authentication-related actions.
 */
class AuthController extends Controller
{
    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request){
      
        $cred= $request->only(["email","password"]);
      if(Auth::attempt($cred)){
        return redirect()->route('landing');
      }
      return redirect('/login')->with('error','Please provide correct credentials...');
    }

    /**
     * Handle user logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) {
        Auth::logout();
        return redirect()->route('login.get');
    }

    /**
     * Display the landing page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function landing(Request $request){
        $companies=Company::all();
        return view('landing',compact('companies'));
    }
}
