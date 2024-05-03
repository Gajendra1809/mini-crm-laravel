<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
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

//Route::resource('/admin',AuthController::class);
Route::view('/login','login')->name('login.get');
Route::post("/login", [AuthController::class,"login"])->name('login.post');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');

Route::get('/landing',[AuthController::class,'landing'])->middleware('auth')->name('landing');

Route::resource('/company',CompanyController::class);

Route::resource('/employee',EmployeeController::class);
