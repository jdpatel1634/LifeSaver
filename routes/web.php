<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These routes define the public pages, authenticated profile routes,
| blood request workflow, donor registration workflow, and authentication
| routes for the LifeSaver blood bank application.
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

Route::controller(BloodRequestController::class)->prefix('request-blood')->name('blood.request.')->group(function () {
    Route::get('/', 'showForm')->name('form');
    Route::post('/', 'submitForm')->name('submit');
});

Route::controller(DonorRegistrationController::class)->prefix('register')->name('donor.register.')->group(function () {
    Route::get('/donor', 'showRegistrationForm')->name('form');
    Route::post('/donor', 'registerDonor')->name('submit');
});

require __DIR__ . '/auth.php';
