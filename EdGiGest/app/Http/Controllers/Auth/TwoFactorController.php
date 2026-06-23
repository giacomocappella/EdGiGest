<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Illuminate\Support\Facades\Crypt;

class TwoFactorController extends Controller
{
    public function enable(Request $request)
    {
        app(EnableTwoFactorAuthentication::class)($request->user());

        $user = $request->user()->fresh();

        $recoveryCodes = json_decode(
            Crypt::decryptString($user->two_factor_recovery_codes),
            true
        );

        return redirect()->route('2fa.setup')->with([
            'show_recovery_codes' => true,
            'recovery_codes' => $recoveryCodes,
        ]);
    }  

    public function showSetup(Request $request)
    {
        return view('auth.2fa-setup');
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $confirmed = app(ConfirmTwoFactorAuthentication::class)(
            $request->user(),
            $request->input('code')
        );

        if (! $confirmed) {
            return back()->withErrors([
                'code' => 'Codice non valido'
            ]);
        }

        return redirect()->route('2fa.setup')
        ->with('show_recovery_codes', true);
    }
    public function disable(Request $request)
    {
        app(DisableTwoFactorAuthentication::class)($request->user());
        return redirect()->route('profile');
    }
}