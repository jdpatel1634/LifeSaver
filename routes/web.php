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

// for temporary purpose
use Illuminate\Support\Facades\Artisan;

Route::get('/setup-database-now', function () {
    Artisan::call('migrate:fresh', [
        '--seed' => true,
        '--force' => true,
    ]);

    return 'Database migrated and seeded successfully.';
});

require __DIR__.'/auth.php';

