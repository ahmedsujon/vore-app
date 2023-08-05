<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\user\DashboardController;
use App\Http\Controllers\api\user\auth\AuthenticationController;
use App\Http\Controllers\api\user\auth\UserResetPasswordController;
use App\Http\Controllers\api\user\FoodController;
use App\Http\Controllers\api\user\MealController;
use App\Http\Controllers\api\user\WaterController;

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

    // Meals APIs

    //breakfast
    Route::get('all-breakfasts', [MealController::class, 'breakfastIndex']);
    Route::get('breakfast', [MealController::class, 'getBreakfast']);
    Route::post('breakfast/add', [MealController::class, 'addBreakfast']);

    //lunch
    Route::get('all-lunches', [MealController::class, 'lunchIndex']);
    Route::get('lunch', [MealController::class, 'getLunch']);
    Route::post('lunch/add', [MealController::class, 'addLunch']);

    //Snacks
    Route::get('all-snacks', [MealController::class, 'snackIndex']);
    Route::get('snack', [MealController::class, 'getSnack']);
    Route::post('snack/add', [MealController::class, 'addSnack']);

    //Dinners
    Route::get('all-dinners', [MealController::class, 'dinnerIndex']);
    Route::get('dinner', [MealController::class, 'getDinner']);
    Route::post('dinner/add', [MealController::class, 'addDinner']);

    //foods api
    Route::get('foods', [FoodController::class, 'getFoods']);
    Route::post('foods/add', [FoodController::class, 'addFood']);

    //Water apis
    Route::get('water/setting', [WaterController::class, 'getWaterSetting']);
    Route::post('water/setting/update', [WaterController::class, 'waterSetting']);
    Route::get('water', [WaterController::class, 'getWater']);
    Route::post('water/add', [WaterController::class, 'addWater']);
});
