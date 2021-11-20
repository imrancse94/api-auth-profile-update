<?php

use App\Http\Controllers\AuthController;
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
Route::post('login',[AuthController::class,'login']);
Route::post('user/register/{unique_key}',[AuthController::class,'userRegister'])->name('user.register');
Route::post('user/confirmation/{unique_key}',[AuthController::class,'userConfirmation'])->name('user.confirmation');

Route::group(['middleware' => ['auth:api']], function() {

      Route::post('register',[AuthController::class,'register']);
      Route::post('invite/user/',[AuthController::class,'sendInvitaion'])->name('invite.user');
      Route::post('user/profile/update',[AuthController::class,'profileUpdate'])->name('user.profile.update');

});
