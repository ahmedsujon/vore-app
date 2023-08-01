<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\user\DashboardController;
use App\Http\Controllers\api\user\auth\AuthenticationController;
use App\Http\Controllers\api\user\auth\UserResetPasswordController;
use App\Http\Controllers\api\user\FoodController;
use App\Http\Controllers\api\user\MealController;

Route::post('v1/login', [AuthenticationController::class, 'login']);
Route::post('v1/register', [AuthenticationController::class, 'register']);
Route::post('v1/reset-password', [UserResetPasswordController::class, 'sendEmail']);
Route::post('v1/change-password', [UserResetPasswordController::class, 'changePassword']);

//Authenticated user
Route::group(['middleware' => ['jwtUser:user-api', 'jwt.auth'], 'prefix' => 'v1/user'], function () {
    Route::post('logout', [AuthenticationController::class, 'userLogout']);

    //User Profile
    Route::post('make-profile', [AuthenticationController::class, 'makeProfile']);
    Route::get('profile', [AuthenticationController::class, 'userProfile']);

    //breakfast
    Route::get('breakfast', [MealController::class, 'getBreakfast']);
    Route::post('breakfast/add', [MealController::class, 'addBreakfast']);

    //breakfast
    Route::get('lunch', [MealController::class, 'getLunch']);
    Route::post('lunch/add', [MealController::class, 'addLunch']);


    //foods api
    Route::get('foods', [FoodController::class, 'foods']);
});
