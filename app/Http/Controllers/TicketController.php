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

    public function index(Request $request)
    {
        $user = $request->user();
        return $this->returnTicketsBasedOnUserRole($user);
    }

    public function store(StoreTicketRequest $request)
    {
        $user = $request->user();
        
        $ticket = Ticket::create($request->validated());

        $ticket->categories()->sync($request->input('categories'));

        return $this->returnTicketsBasedOnUserRole($user);
    }

    //TODO: Fix this
    public function update(StoreTicketRequest $request, Ticket $ticket) {
        $user = $request->user();
        
        $ticket->categories()->sync($request->input('categories'));
        $ticket->reactions()->sync($request->input('reactions'));
        
        $ticket->update($request->validated());
        $tickets = Ticket::all();
        
        return $this->returnTicketsBasedOnUserRole($user, $tickets);
    }
    
    private function returnTicketsBasedOnUserRole($user, $tickets = null) {
        
        if($user->is_admin == false) {
            return Ticket::with(['reactions.user', 'categories'])->where('reporter_id', $user['id'])->get();
        };
        return Ticket::with(['reactions.user', 'categories'])->get();
    }
}
