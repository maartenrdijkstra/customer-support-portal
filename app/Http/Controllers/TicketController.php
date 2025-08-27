<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    // Alle tickets (met categorieën)
    public function allTickets()
    {
        return Ticket::with('categories')->get();
    }

    // Alleen tickets van de ingelogde user
    public function userTickets(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return Ticket::with('categories')
            ->where('reporter_id', $user->id)
            ->get();
    }
}

