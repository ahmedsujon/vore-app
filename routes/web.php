<?php

use App\Livewire\App\Contact\ContactComponent;
use App\Livewire\App\Pages\PrivacyPolicyComponent;
use App\Livewire\App\Pages\TermsConditionComponent;
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

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('privacy-policy', PrivacyPolicyComponent::class)->name('privacy.policy');
Route::get('terms-and-conditions', TermsConditionComponent::class)->name('terms.conditions');

// Contact Route
Route::get('contact-us', ContactComponent::class)->name('app.contact.us');


//Call Route Files
require __DIR__ . '/admin.php';
