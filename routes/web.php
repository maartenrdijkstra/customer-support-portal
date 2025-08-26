<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:sanctum')->get('/api/alltickets', function (Request $request) {
    return Ticket::all();
});

Route::middleware('auth:sanctum')->get('/api/usertickets', function (Request $request) {
    $user = $request->user();
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $tickets = Ticket::where('reporter_id', $user->id)->get();
    return response()->json($tickets);
});

Route::middleware('auth:sanctum')->get('/api/users', function (Request $request) {
    return User::all();
});

Route::middleware('auth:sanctum')->get('/api/categories', function (Request $request) {
    return Category::all();
});

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

Route::get('/{any}', function () {
    return view('welcome'); 
})->where('any', '.*');
