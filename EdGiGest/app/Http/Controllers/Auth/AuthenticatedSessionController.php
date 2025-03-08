<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Gestisce il login dell'utente e il reindirizzamento post-login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Autenticazione dell'utente
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->current_team_id !== '0000000000') {
                
                return redirect()->route('dashboard.client');
            }
            else                
                return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Le credenziali fornite non sono valide.',
        ]);
    }

    /**
     * Disconnette l'utente attualmente autenticato.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        // Invalida la sessione dell'utente
        $request->session()->invalidate();

        // Rigenera il token della sessione per prevenire attacchi CSRF
        $request->session()->regenerateToken();

        // Reindirizza alla pagina di login dopo il logout
        return redirect('/login');
    }
}
