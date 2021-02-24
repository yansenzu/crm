<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminController;

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
Route::post('/v1/admin/edituser/{hondaid}', [AdminController::class, 'edituser']);
Route::post('v1/admin/deleteuser/{hondaid}', [AdminController::class, 'deleteuser']);
Route::post('/v1/admin/loginadmin', [AdminController::class, 'loginadmin']);