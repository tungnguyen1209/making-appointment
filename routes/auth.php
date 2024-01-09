<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ConfirmablePasswordController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\NewPasswordController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\PasswordResetLinkController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

/**
 * Get All Guest Routes
 *
 * @return void
 */
function getGuestRoutes(): void
{
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('admin.login');

        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('admin.password.request');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('admin.password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('admin.password.reset');

        Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('admin.password.store');
    });
}

/**
 * Get All Auth Routes
 *
 * @return void
 */
function getAuthRoutes(): void
{
    Route::middleware('auth')->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('profile', [ProfileController::class, 'edit'])
            ->name('admin.profile.edit');

        Route::patch('profile', [ProfileController::class, 'update'])
            ->name('admin.profile.update');

        Route::get('customer', [CustomerController::class, 'index'])
            ->name('admin.customer.index');

        Route::get('customer/view/id/{id}', [CustomerController::class, 'view'])
            ->name('admin.customer.view');

        Route::get('appointment', [AppointmentController::class, 'index'])
            ->name('admin.appointment.index');

        Route::get('appointment/create', [AppointmentController::class, 'createForm'])
            ->name('admin.appointment.create.form');

        Route::post('appointment/create', [AppointmentController::class, 'create'])
            ->name('admin.appointment.create');

        Route::get('appointment/view/id/{id}', [AppointmentController::class, 'view'])
            ->name('admin.appointment.view');

        Route::post('appointment/update/id/{id}', [AppointmentController::class, 'update'])
            ->name('admin.appointment.update');

        Route::put('appointment/cancel/{id}', [AppointmentController::class, 'cancel'])
            ->name('admin.appointment.cancel');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('admin.password.confirm');

        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::put('password', [PasswordController::class, 'update'])->name('admin.password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('admin.logout');
    });
}

Route::prefix('admin')->group(function (){
   getGuestRoutes();
   getAuthRoutes();
});
