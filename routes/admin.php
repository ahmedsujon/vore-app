<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Livewire\Admin\DashboardComponent;
use App\Livewire\Admin\Auth\LoginComponent;
use App\Livewire\Admin\Customers\CustomerComponent;
use App\Livewire\Admin\Users\UserComponent;
use App\Livewire\Admin\Users\UsersComponent;
use App\Livewire\Admin\Users\AdminsComponent;
use App\Livewire\Admin\Profile\ProfileComponent;
use App\Livewire\Admin\Measurements\MeasurementsComponent;

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
Route::prefix('admin/')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::post('logout', [LogoutController::class, 'adminLogout'])->name('logout');


    Route::get('dashboard', DashboardComponent::class)->name('dashboard');
    Route::get('customers', CustomerComponent::class)->name('customers');

    //user management
    Route::get('all-users', UsersComponent::class)->name('allUsers')->middleware('adminPermission:users_manage');
    Route::get('all-admins', AdminsComponent::class)->name('allAdmins')->middleware('adminPermission:admins_manage');
});
