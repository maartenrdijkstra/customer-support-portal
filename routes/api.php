<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware(['web', 'auth:sanctum'])->get('/categorytickets', function (Request $request) {
    return Ticket::where('category_id', $request->input('category_id'))->get();
});

Route::middleware(['web', 'auth:sanctum'])->get('/alltickets', [TicketController::class, 'allTickets']);
Route::middleware(['web', 'auth:sanctum'])->get('/usertickets', [TicketController::class, 'userTickets']);
Route::middleware('auth:sanctum')->get('/categorytickets', function (Request $request) {
    return Ticket::where('category_id', $request->input('category_id'))->get();
});
Route::middleware('auth:sanctum')->post('/tickets', [TicketController::class, 'store']);