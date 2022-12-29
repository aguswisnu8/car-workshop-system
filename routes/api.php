<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});


Route::controller(UserController::class)->group( function (){
    Route::get('me','me');
    Route::get('users','getAllUsers');
    Route::post('role/{id}','changeRole');
});

Route::controller(CarController::class)->group( function (){
    Route::get('cars','all');
    Route::post('car','store');
    Route::post('car/{id}','update');
});

Route::controller(ProposalController::class)->group( function (){
    Route::get('proposals','all');
    Route::post('proposal','store');
    Route::post('proposal/{id}','update');
});
Route::controller(ServiceController::class)->group( function (){
    Route::get('services','all');
    Route::post('service','store');
    Route::post('service/{id}','update');
});



