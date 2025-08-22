<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\User;

class PasswordResetController extends Controller
{
    // Stap 1: stuur reset link naar email
    public function sendResetLinkEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $token = Str::random(60);

    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $request->email],
        [
            'email'      => $request->email,
            'token'      => Hash::make($token),
            'created_at' => Carbon::now(),
        ]
    );

    // Link genereren met token & email
    $resetLink = url("/reset-password?token={$token}&email={$request->email}");

    // Mail sturen (hier placeholder)
    // Mail::to($request->email)->send(new ResetPasswordMail($resetLink));

    return response()->json([
        'success' => true,
        'message' => 'Resetlink is verzonden naar je e-mailadres.',
        'reset_link' => $resetLink // voor test/doorgeven aan frontend
    ]);
}

    // Stap 2: reset het wachtwoord
    public function reset(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'token'    => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->latest()
            ->first();

        if (! $reset) {
            return response()->json([
                'success' => false,
                'message' => 'Geen resetverzoek gevonden.'
            ], 400);
        }

        // Token check (hier heel simpel gedaan; in productie strikter doen)
        if (! Hash::check($request->token, $reset->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Ongeldig token.'
            ], 400);
        }

        // Check of token verlopen is (bijv. 60 minuten)
        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Token is verlopen.'
            ], 400);
        }

        // Update wachtwoord
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Verwijder token zodat het niet opnieuw gebruikt kan worden
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wachtwoord is succesvol gereset.'
        ]);
    }
}