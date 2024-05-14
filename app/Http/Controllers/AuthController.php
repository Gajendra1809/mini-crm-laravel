<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Employee;
use Carbon\Carbon;

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
        return redirect()->route('landing')->with('success','Logged in...');
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
     * Display the landing page with some analytics data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function landing(Request $request){
        $totalCompanies=Company::all()->count();
        $lastWeekComp = Company::whereDate('created_at', '>=', Carbon::now()->subWeek())->get()->count();
        $lastMonthComp=Company::whereDate('created_at', '>=', Carbon::now()->subMonth())->get()->count();

        $totalEmployees=Employee::all()->count();
        $lastWeekEmp=Employee::whereDate('created_at', '>=', Carbon::now()->subWeek())->get()->count();
        $lastMonthEmp=Employee::whereDate('created_at', '>=', Carbon::now()->subMonth())->get()->count();

        $analyticsData=(object)['total_company'=>$totalCompanies,'total_employee'=>$totalEmployees,'last_week_comp'=>$lastWeekComp,'last_week_emp'=>$lastWeekEmp,'last_month_comp'=>$lastMonthComp,'last_month_emp'=>$lastMonthEmp];
        return view('landing',compact('analyticsData'));
    }
}
