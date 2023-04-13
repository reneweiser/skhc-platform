<?php

use App\Http\Controllers\AdminAuthenticationController;
use App\Http\Controllers\AdminVolunteerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditTokenController;
use App\Http\Controllers\EditTokenCreatedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerificationRequestedController;
use App\Http\Controllers\VerificationSuccessfulController;
use App\Http\Controllers\VolunteerAuthenticationController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\VolunteerDeletedController;
use App\Http\Controllers\VolunteersDownloadController;
use App\Http\Controllers\VolunteerUpdatedController;
use App\Http\Controllers\VolunteerVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, '__invoke'])->name('home');
Route::get('/signup', fn() => redirect()->route('volunteer.create'))->name('signup');

Route::get('/volunteers/create', [VolunteerController::class, 'create'])->name('volunteer.create');
Route::post('/volunteers', [VolunteerController::class, 'store'])->name('volunteer.store');
Route::get('/volunteers/{token}/edit', [VolunteerController::class, 'edit'])->name('volunteer.edit');
Route::put('/volunteers/{token}', [VolunteerController::class, 'update'])->name('volunteer.update');
Route::delete('/volunteers/{token}', [VolunteerController::class, 'destroy'])->name('volunteer.destroy');

Route::get('/verification-notice', [VerificationRequestedController::class, '__invoke'])->name('volunteer.verification.notice');
Route::get('/successful-notice', [VerificationSuccessfulController::class, '__invoke'])->name('volunteer.successful.notice');
Route::get('/updated-notice', [VolunteerUpdatedController::class, '__invoke'])->name('volunteer.updated.notice');
Route::get('/deleted-notice', [VolunteerDeletedController::class, '__invoke'])->name('volunteer.deleted.notice');

Route::get('/volunteers/verify/{token}', [VolunteerVerificationController::class, '__invoke'])->name('volunteer.verify');
Route::get('/volunteers/auth/{token}', [VolunteerAuthenticationController::class, '__invoke'])->name('volunteer.authenticate');

Route::get('/edit-tokens/create', [EditTokenController::class, 'create'])->name('edit-token.create');
Route::post('/edit-tokens', [EditTokenController::class, 'store'])->name('edit-token.store');
Route::delete('/edit-tokens/{token}', [EditTokenController::class, 'destroy'])->name('edit-token.destroy');
Route::get('/edit-token-created-notice', [EditTokenCreatedController::class, '__invoke'])->name('edit-token.created.notice');

Route::get('/process-expired', fn() => inertia('ProcessExpired'))->name('process.expired');

Route::post('/admin-authentication', [AdminAuthenticationController::class, 'store'])->name('admin-auth.store');
Route::get('/admin-authentication/notice', [AdminAuthenticationController::class, 'notice'])->name('admin-auth.notice');
Route::get('/admin-authentication/{adminAuthentication}/login', [AdminAuthenticationController::class, 'destroy'])->name('admin-auth.login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, '__invoke'])->name('dashboard');

    Route::get('/admin/volunteers', [AdminVolunteerController::class, 'index'])->name('admin.volunteer.index');
    Route::get('/admin/volunteers/create', [AdminVolunteerController::class, 'create'])->name('admin.volunteer.create');
    Route::post('/admin/volunteers', [AdminVolunteerController::class, 'store'])->name('admin.volunteer.store');
    Route::get('/admin/volunteers/{volunteer}/edit', [AdminVolunteerController::class, 'edit'])->name('admin.volunteer.edit');
    Route::put('/admin/volunteers/{volunteer}', [AdminVolunteerController::class, 'update'])->name('admin.volunteer.update');
    Route::delete('/admin/volunteers/{volunteer}', [AdminVolunteerController::class, 'destroy'])->name('admin.volunteer.destroy');
    Route::delete('/admin/volunteers', [AdminVolunteerController::class, 'destroyAll'])->name('admin.volunteer.destroy.all');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/volunteers-download', [VolunteersDownloadController::class, '__invoke'])->name('volunteers.download');
});

require __DIR__ . '/auth.php';
