<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use App\Http\Middleware\isGuestMiddleware;
use App\Http\Middleware\isLoginMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'home'])->middleware([isLoginMiddleware::class]);
Route::get('/mail', [MailController::class, 'sendMail']);

Route::controller(AuthController::class)->group(function(){
    Route::get('/login','login')->middleware([isGuestMiddleware::class]);
    Route::post('/login','doLogin')->middleware([isGuestMiddleware::class]);
    Route::post('/logout','doLogout')->middleware([isLoginMiddleware::class]);

    Route::get('/register','register')->middleware([isGuestMiddleware::class]);
    Route::post('/register','doRegister')->middleware([isGuestMiddleware::class]);
});
