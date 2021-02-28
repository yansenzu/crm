<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasswordController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Route Admin
Route::prefix('v1/admin')->group(function () {
    Route::post('user', [AdminController::class, 'adduser']);
    Route::put('user/{hondaid}', [AdminController::class, 'edituser']);
    Route::post('user/{hondaid}', [AdminController::class, 'deleteuser']);
    Route::post('loginadmin', [AdminController::class, 'loginadmin']);
    Route::put('updatepassword/{hondaid}', [PasswordController::class, 'updatepassword']);
});

//Route User
Route::prefix('v1/users')->group(function () {
    Route::get('profile', [UserController::class, 'getprofile']);
    Route::put('profile', [UserController::class, 'edituserprofile']);
    Route::post('uploadimmage/{hondaid}', [UserController::class, 'uploadimmage']);
    Route::put('updateuserpassword', [PasswordController::class, 'updateuserpassword']);
});