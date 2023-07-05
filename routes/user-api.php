<?php

use Illuminate\Support\Facades\Route;


// Route::post('v1/login', [UserAuthenticationController::class, 'login']);

//Authenticated user
Route::group(['middleware' => ['jwtUser:user-api', 'jwt.auth'], 'prefix' => 'v1/dashboard'], function () {
    // Route::post('logout', [UserAuthenticationController::class, 'userLogout']);

    //Supports
    // Route::get('support-tickets', [SupportController::class, 'index']);
});
