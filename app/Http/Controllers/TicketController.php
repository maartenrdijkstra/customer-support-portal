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
        $ticket = Ticket::create($request->validated());

        $ticket->categories()->sync($request->input('categories'));

        return new TicketResource($ticket->load('categories'));
    }

    public function update(StoreTicketRequest $request, Ticket $ticket) {
        $ticket->update($request->validated());

        $ticket->categories()->sync($request->input('categories'));
        
        $tickets = Ticket::all();
        
        return TicketResource::collection($tickets);
    }
}
