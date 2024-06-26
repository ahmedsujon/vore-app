<?php

use App\Http\Controllers\AppController;
use App\Livewire\App\Contact\ContactComponent;
use App\Livewire\App\HomeComponent;
use App\Livewire\App\Pages\AboutComponent;
use App\Livewire\App\Pages\PrivacyPolicyComponent;
use App\Livewire\App\Pages\TermsConditionComponent;
use App\Livewire\App\Pages\UnsubscribeComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', HomeComponent::class)->name('app.home');
Route::get('/unsubscribe', UnsubscribeComponent::class)->name('app.unsubscribe');

Route::get('privacy-policy', PrivacyPolicyComponent::class)->name('privacy.policy');
Route::get('terms-and-conditions', TermsConditionComponent::class)->name('terms.conditions');

// Contact Route
Route::get('contact-us', ContactComponent::class)->name('app.contact.us');

// About us Route
Route::get('about-us', AboutComponent::class)->name('app.aboutus');

// Email Verify
Route::get('email-verification', [AppController::class, 'verifyEmail']);


//Call Route Files
require __DIR__ . '/admin.php';
