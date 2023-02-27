<?php

use App\Http\Controllers\CompleteSignupPromptController;
use App\Http\Controllers\CreateEditTokenController;
use App\Http\Controllers\StoreEditTokenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VolunteerAuthController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\VolunteerVerificationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('volunteer.create');
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/signup', [VolunteerController::class, 'create'])->name('volunteer.create');
Route::post('/volunteers', [VolunteerController::class, 'store'])->name('volunteer.store');
Route::put('/volunteers/{volunteer}', [VolunteerController::class, 'update'])->name('volunteer.update');
Route::delete('/volunteers/{volunteer}', [VolunteerController::class, 'destroy'])->name('volunteer.destroy');

Route::get('/complete-signup-notice', [CompleteSignupPromptController::class, '__invoke'])->name('volunteer.complete-signup-notice');
Route::get('/volunteers/verify/{token}', [VolunteerVerificationController::class, '__invoke'])->name('volunteer.verify');
Route::get('/volunteers/auth/{token}', [VolunteerAuthController::class, '__invoke'])->name('volunteer.authenticate');

Route::get('/edit-token/create', [CreateEditTokenController::class, '__invoke'])->name('edit-token.create');
Route::post('/edit-token', [StoreEditTokenController::class, '__invoke'])->name('edit-token.store');

require __DIR__.'/auth.php';
