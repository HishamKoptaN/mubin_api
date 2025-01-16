<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CheckController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ChangePassController;
use Illuminate\Support\Facades\Route;

Route::post('/check', [CheckController::class, 'check']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/edit-pass', [ChangePassController::class, 'edit']);
Route::get(
    '/test',
    function () {
        return "test auth";
    },
);
