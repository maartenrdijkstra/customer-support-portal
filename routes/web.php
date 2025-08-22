<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/{any}', function () {
    return view('welcome'); 
})->where('any', '.*');

Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return response()->json(['success' => true]);
});

Route::middleware('auth:sanctum')->get('/api/me', function (Request $request) {
    return $request->user();
});

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);