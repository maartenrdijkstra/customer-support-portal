<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/{any}', function () {
    return view('welcome'); // <- Vue SPA
})->where('any', '.*');

Route::post('/login', [LoginController::class, 'authenticate']);


Route::middleware('auth:sanctum')->get('/api/me', function (Request $request) {
    return $request->user();
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return response()->json(['success' => true]);
});