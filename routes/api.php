<?php

use App\Http\Controllers\TicketController;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'auth:sanctum'])->get('/me', function (Request $request) {
    return $request->user();
});

Route::middleware(['web', 'auth:sanctum'])->get('/users', function (Request $request) {
    return User::all();
});

Route::middleware(['web', 'auth:sanctum'])->get('/categories', function (Request $request) {
    return Category::all();
});


Route::middleware(['web', 'auth:sanctum'])->get('/categorytickets', function (Request $request) {
    return Ticket::where('category_id', $request->input('category_id'))->get();
});

Route::middleware(['web', 'auth:sanctum'])->get('/alltickets', [TicketController::class, 'allTickets']);
Route::middleware(['web', 'auth:sanctum'])->get('/usertickets', [TicketController::class, 'userTickets']);