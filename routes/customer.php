<?php

use App\Http\Controllers\Customer\AppointmentController;
use App\Http\Controllers\Customer\AuthenticatedSessionController;
use App\Http\Controllers\Customer\ConfirmablePasswordController;
use App\Http\Controllers\Customer\EmailVerificationNotificationController;
use App\Http\Controllers\Customer\EmailVerificationPromptController;
use App\Http\Controllers\Customer\NewPasswordController;
use App\Http\Controllers\Customer\PasswordController;
use App\Http\Controllers\Customer\PasswordResetLinkController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\RegisteredCustomerController;
use App\Http\Controllers\Customer\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/**
 * Get All Guest Routes
 *
 * @return void
 */
function getGuestCustomerRoutes(): void
{
    Route::middleware('guest')->group(function () {
        Route::get('/', function () {
            return view('customer.welcome');
        })->name('home');

        Route::get('register', [RegisteredCustomerController::class, 'create'])
            ->name('customer.register');

        Route::post('register', [RegisteredCustomerController::class, 'store']);

        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('customer.login');

        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('customer.password.request');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('customer.password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('customer.password.reset');

        Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('customer.password.store');
    });
}

/**
 * Get All Auth Routes
 *
 * @return void
 */
function getAuthCustomerRoutes(): void
{
    Route::middleware(['auth:customer'])->group(function () {
        Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, "verify"])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('customer.verification.verify');

        Route::get('verify-email', EmailVerificationPromptController::class)
            ->name('customer.verification.notice');

        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('customer.verification.send');

        Route::middleware(['customer.verified'])->group(function () {
            Route::get('dashboard', function () {
                return view('customer.dashboard');
            })->name('customer.dashboard');

            Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('customer.password.confirm');

            Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

            Route::put('password', [PasswordController::class, 'update'])
                ->name('customer.password.update');

            Route::get('profile', [ProfileController::class, 'edit'])
                ->name('customer.profile.edit');

            Route::patch('profile', [ProfileController::class, 'update'])
                ->name('customer.profile.update');

            Route::delete('profile', [ProfileController::class, 'destroy'])
                ->name('customer.profile.destroy');

            Route::get('appointment', [AppointmentController::class, 'index'])
                ->name('customer.appointment.index');

            Route::get('appointment/create', function () {
                return view('customer.appointment.create');
            });

            Route::post('appointment/create', [AppointmentController::class, 'create'])
                ->name('customer.appointment.create');

            Route::get('appointment/edit/{id}', [AppointmentController::class, 'edit'])
                ->name('customer.appointment.edit');

            Route::patch('appointment', [AppointmentController::class, 'update'])
                ->name('customer.appointment.update');

            Route::delete('appointment', [AppointmentController::class, 'destroy'])
                ->name('customer.appointment.destroy');

            Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('customer.logout');
        });
    });
}

getGuestCustomerRoutes();
getAuthCustomerRoutes();


