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
Route::post('/v1/admin/adduser', [AdminController::class, 'adduser']);
Route::put('/v1/admin/edituser/{hondaid}', [AdminController::class, 'edituser']);
Route::post('v1/admin/deleteuser/{hondaid}', [AdminController::class, 'deleteuser']);
Route::post('/v1/admin/loginadmin', [AdminController::class, 'loginadmin']);
Route::put('/v1/admin/updatepassword/{hondaid}', [PasswordController::class, 'updatepassword']);

//Route User
Route::get('/v1/users/userprofile', [UserController::class, 'getprofile']);
Route::put('/v1/users/edituserprofile', [UserController::class, 'edituserprofile']);
Route::post('/v1/users/uploadimmage', [UserController::class, 'uploadimmage']);
Route::put('/v1/users/updateuserpassword', [PasswordController::class, 'updateuserpassword']);