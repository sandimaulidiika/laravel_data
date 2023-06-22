<?php

use App\Http\Controllers\EmailVerificationNotificationController;
use App\Http\Controllers\EmailVerificationPromptController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register');





    Route::get('verify-email', EmailVerificationPromptController::class, '@__invoke')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class . '@__invoke')
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', EmailVerificationNotificationController::class . '@__invoke')
        ->middleware('throttle:6,1')
        ->name('verification.send');
});
