<?php

use App\Http\Controllers\api\user\ActivityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\user\DashboardController;
use App\Http\Controllers\api\user\auth\AuthenticationController;
use App\Http\Controllers\api\user\auth\UserResetPasswordController;
use App\Http\Controllers\api\user\auth\VerificationController;
use App\Http\Controllers\api\user\ContactController;
use App\Http\Controllers\api\user\FoodController;
use App\Http\Controllers\api\user\MealController;
use App\Http\Controllers\api\user\MeasurementController;
use App\Http\Controllers\api\user\ProfileController;
use App\Http\Controllers\api\user\TeamController;
use App\Http\Controllers\api\user\WaterController;

Route::post('v1/login', [AuthenticationController::class, 'login']);
Route::post('v1/register', [AuthenticationController::class, 'register']);
Route::post('v1/reset-password', [UserResetPasswordController::class, 'sendEmail']);
Route::post('v1/change-password', [UserResetPasswordController::class, 'changePassword']);

//Authenticated user
Route::group(['middleware' => ['jwtUser:user-api', 'jwt.auth'], 'prefix' => 'v1/user'], function () {
    Route::post('logout', [AuthenticationController::class, 'userLogout']);
    Route::post('send-verification-mail', [VerificationController::class, 'sendEmailVerificationMail']);
    Route::get('verification-status', [VerificationController::class, 'getVerificationStatus']);

    //User Profile
    Route::post('make-profile', [AuthenticationController::class, 'makeProfile']);
    Route::get('profile', [AuthenticationController::class, 'userProfile']);

    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('todays-goal', [DashboardController::class, 'todaysGoal']);
    Route::get('measurements', [DashboardController::class, 'getMeasurement']);
    Route::post('update-measurements', [DashboardController::class, 'updateMeasurement']);

    Route::get('dashboard/waters', [DashboardController::class, 'getWater']);
    Route::post('dashboard/add-water', [DashboardController::class, 'addWater']);

    // Meals APIs
    //breakfast
    Route::get('all-breakfasts', [MealController::class, 'breakfastIndex']);
    Route::get('breakfast', [MealController::class, 'getBreakfast']);
    Route::post('breakfast/add', [MealController::class, 'addBreakfast']);
    Route::post('breakfast/update', [MealController::class, 'updateBreakfast']);
    Route::get('breakfast/delete', [MealController::class, 'deleteBreakfast']);

    //lunch
    Route::get('all-lunches', [MealController::class, 'lunchIndex']);
    Route::get('lunch', [MealController::class, 'getLunch']);
    Route::post('lunch/add', [MealController::class, 'addLunch']);
    Route::post('lunch/update', [MealController::class, 'updateLunch']);
    Route::get('lunch/delete', [MealController::class, 'deleteLunch']);

    //Snacks
    Route::get('all-snacks', [MealController::class, 'snackIndex']);
    Route::get('snack', [MealController::class, 'getSnack']);
    Route::post('snack/add', [MealController::class, 'addSnack']);
    Route::post('snack/update', [MealController::class, 'updateSnack']);
    Route::get('snack/delete', [MealController::class, 'deleteSnack']);

    //Dinners
    Route::get('all-dinners', [MealController::class, 'dinnerIndex']);
    Route::get('dinner', [MealController::class, 'getDinner']);
    Route::post('dinner/add', [MealController::class, 'addDinner']);
    Route::post('dinner/update', [MealController::class, 'updateDinner']);
    Route::get('dinner/delete', [MealController::class, 'deleteDinner']);

    //foods api
    Route::get('foods', [FoodController::class, 'getFoods']);
    Route::post('foods/add', [FoodController::class, 'addFood']);

    //Water apis
    Route::get('water/setting', [WaterController::class, 'getWaterSetting']);
    Route::post('water/setting/update', [WaterController::class, 'waterSetting']);
    Route::get('water', [WaterController::class, 'getWater']);
    Route::post('water/add', [WaterController::class, 'addWater']);

    //Activities
    Route::get('all-activities', [ActivityController::class, 'allActivities']);
    Route::post('activity/add', [ActivityController::class, 'addNewActivity']);

    Route::get('user-activity', [ActivityController::class, 'userActivityDetails']);
    Route::post('user-activity/add', [ActivityController::class, 'addUserActivity']);
    Route::get('user-activity/delete', [ActivityController::class, 'deleteUserActivity']);

    //profile
    Route::get('my-profile', [ProfileController::class, 'index']);
    Route::get('profile-details', [ProfileController::class, 'profileDetails']);
    Route::post('update-profile', [ProfileController::class, 'updateProfile']);
    Route::get('progress', [ProfileController::class, 'progress']);
    Route::get('my-goals', [ProfileController::class, 'myGoals']);
    Route::post('my-goals/update', [ProfileController::class, 'updateMyGoals']);
    Route::get('nutrient-goals', [ProfileController::class, 'nutrientGoals']);

    // Measurements
    Route::get('my-measurements', [MeasurementController::class, 'allMeasurements']);
    Route::post('my-measurements/add', [MeasurementController::class, 'addMeasurement']);
    Route::get('my-measurements/edit', [MeasurementController::class, 'editMeasurement']);
    Route::post('my-measurements/update', [MeasurementController::class, 'updateMeasurement']);

    // contact
    Route::post('contact-us', [ContactController::class, 'contactUs']);

    // team
    Route::get('our-team', [TeamController::class, 'index']);

});
