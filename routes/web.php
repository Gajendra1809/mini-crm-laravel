<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//These are Authentication related routes for login and logout
Route::view('/login','login')->name('login.get')->middleware('isLogin');
Route::post("/login", [AuthController::class,"login"])->name('login.post');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');
Route::get('/',[AuthController::class,'landing'])->name('landing');


//auth middlware applied on group routes, unauthenticated user will not allowed access those routes
Route::middleware('auth')->group(function(){

    //for handling company actions
    Route::resource('/company',CompanyController::class);
    
    //for handling employee actions
    Route::resource('/employee',EmployeeController::class);

    //for exporting compnies csv file
    Route::get('/export/companies',[CompanyController::class,'export'])->name('company.export');
    
    //for exporting employees csv file
    Route::get('/export/employees',[EmployeeController::class,'export'])->name('employee.export');

    //api for getting latitude and longitude for given city name
    Route::get('/map',[CompanyController::class,'map'])->name('company.map');

    //for handling the company restore request
    Route::get('/restore',[CompanyController::class,'restore'])->name('company.restore');
    
});

//redirect to '/' if unknown route exists
Route::fallback(function(){
    return redirect('/');
});
