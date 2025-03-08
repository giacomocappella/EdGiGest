<?php

namespace App\Http\Controllers\Put;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class StoreEditProfile extends Controller
{
    public function __invoke(Request $request){
          
        $userId = Auth::id();

        $user=User::findOrFail($userId);
 
        // Aggiorna i campi
        $user->CF = $request->CF;
        $user->Via = $request->Via;
        $user->Civico = $request->Civico;
        $user->Citta = $request->Citta;
        $user->CAP = $request->CAP;
        $user->Provincia = $request->Provincia;
        $user->iban = $request->iban;

        // Se è stata inserita una nuova password, la aggiorna hashandola
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Salva le modifiche
        $user->save();

        if ($request->password) 
        return redirect()->route('logout');

        else
            return redirect()->route('profile');
       
        
    }
}
