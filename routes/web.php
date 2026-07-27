<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/find-blood', [HomeController::class, 'handleSearch'])->name('blood.handleSearch');

Route::get('/request-blood', [App\Http\Controllers\BloodRequestController::class, 'showForm'])->name('blood.request.form');
Route::post('/request-blood', [App\Http\Controllers\BloodRequestController::class, 'submitForm'])->name('blood.request.submit');

Route::get('/register/donor', [App\Http\Controllers\DonorRegistrationController::class, 'showRegistrationForm'])->name('donor.register.form');
Route::post('/register/donor', [App\Http\Controllers\DonorRegistrationController::class, 'registerDonor'])->name('donor.register.submit');

Route::view('/about-us', 'pages.about')->name('about');

Route::view('/find-blood-near-you', 'pages.find-blood')->name('blood.find');

Route::view('/donation-camps', 'pages.donation-camps')->name('donation.camps');

Route::view('/faqs', 'pages.faqs')->name('faqs');

Route::view('/eligibility-checker', 'pages.eligibility-checker')->name('eligibility.checker');

Route::view('/donation-process', 'pages.donation-process')->name('donation.process');

Route::view('/health-guidelines', 'pages.health-guidelines')->name('health.guidelines');

Route::view('/privacy-policy', 'pages.privacy-policy')->name('privacy.policy');

Route::view('/donation-types/whole-blood', 'pages.donation-types.whole-blood')->name('donation.whole-blood');

Route::view('/donation-types/platelet', 'pages.donation-types.platelet')->name('donation.platelet');

Route::view('/donation-types/plasma', 'pages.donation-types.plasma')->name('donation.plasma');

require __DIR__.'/auth.php';
