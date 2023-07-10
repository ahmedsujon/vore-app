<?php

use App\Http\Controllers\api\user\auth\AuthenticationController;
use App\Http\Controllers\api\user\DashboardController;
use Illuminate\Support\Facades\Route;


Route::post('v1/login', [AuthenticationController::class, 'login']);
Route::post('v1/register', [AuthenticationController::class, 'register']);

//Authenticated user
Route::group(['middleware' => ['jwtUser:user-api', 'jwt.auth'], 'prefix' => 'v1/user'], function () {
    Route::post('logout', [AuthenticationController::class, 'userLogout']);

    //User Profile
    Route::get('profile', [AuthenticationController::class, 'userProfile']);
});
