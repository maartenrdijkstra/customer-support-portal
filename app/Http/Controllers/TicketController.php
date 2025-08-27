<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
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

    public function store(StoreTicketRequest $request)
    {
        // Ticket aanmaken
        $ticket = Ticket::create([
            'title' => $request->title,
            'status' => $request->status,
            'reporter_id' => $request->reporter_id,
            'assignee_id' => $request->assignee_id,
            'made_timestamp' => now(),
            'last_update_on' => now(),
        ]);

        // Categories koppelen
        if ($request->categories) {
            $ticket->categories()->sync($request->categories);
        }

        // Resource teruggeven
        return new TicketResource($ticket->load('categories'));
    }
}

