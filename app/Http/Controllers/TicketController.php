<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Arr;

class TicketController extends Controller
{

    // TO DO: Fix this
    public function index(Request $request)
    {
        $user = $request->user;
        $userId = $user['id'];
        $tickets = Ticket::with(['reactions.user', 'categories']);

        if($user->is_admin == false) {
           return ($tickets)->where('reporter_id', $userId)->all()->get();
            };
        return $tickets->get();
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
