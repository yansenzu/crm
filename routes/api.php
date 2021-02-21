<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controller\BukuTamuController;

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

Route::get('/v1/users', [UsersController::class, 'index']);
Route::get('/v1/users/{id}', [UsersController::class, 'usersbyid']);
Route::post('/v1/users/register', [RegisterController::class, 'register']);
Route::post('/v1/users/login', [LoginController::class, 'login']);
Route::post('/v1/users/uploadbukutamu', [BukuTamuController::class, 'upload_bukutamu']);