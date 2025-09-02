<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReactionController extends Controller
{
    // Alleen ingelogde gebruikers mogen reactions ophalen
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $user->reactions()->with('ticket')->get();
    }
}
