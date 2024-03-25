<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Livewire\Admin\DashboardComponent;
use App\Livewire\Admin\Auth\LoginComponent;
use App\Livewire\Admin\Measurements\MeasurementsComponent;
use App\Livewire\Admin\Profile\ProfileComponent;
use App\Livewire\Admin\Users\UserComponent;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Admin" middleware group. Now create something great!
|
*/

Route::get('admin/login', LoginComponent::class)->middleware('guest:admin')->name('admin.login');

Route::get('admin', DashboardComponent::class)->middleware('auth:admin');
Route::prefix('admin/')->name('admin.')->middleware('auth:admin')->group(function(){
    Route::post('logout', [LogoutController::class, 'adminLogout'])->name('logout');

    Route::get('profile', ProfileComponent::class)->name('profile');

    Route::get('dashboard', DashboardComponent::class)->name('dashboard');
    Route::get('users', UserComponent::class)->name('users');
    Route::get('measurements', MeasurementsComponent::class)->name('measurements');
});
