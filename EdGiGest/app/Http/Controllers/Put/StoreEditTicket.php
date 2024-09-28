<?php

namespace App\Http\Controllers\Put;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StoreEditTicket extends Controller
{
    public function __invoke(Request $request){
        
        $idticket=$request->input('idticket');

        $request->validate( [
            'Ticket_name.required' => 'Il nome del ticket è obbligatorio.',
            ]);

        //FACCIO L'UPLOAD TICKET SU CLOCKIFY TRAMITE API PUT
        // La chiave API
        $apiKey = env('API_KEY'); 

        $urlticket="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects/$idticket";
        // URL dell'API
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->withoutVerifying()->put($urlticket, [
        'name' => $request->Ticket_name,
        ]);
        //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)


        // Verifico se la chiamata ha avuto successo
        if ($response->successful()) {
            session(['idticket' => $idticket]);
            return redirect()->route('get.tasks')->with('success', 'Ticket modificato correttamente!');
            } 
        else {
            return response()->json([
                'error' => 'Request failed',
                'status' => $response->status(),
                'message' => $response->body(),
                ], $response->status());
        }
    }
}
