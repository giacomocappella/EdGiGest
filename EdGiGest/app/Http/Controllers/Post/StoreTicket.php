<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Http;

class StoreTicket extends Controller
{
    public function __invoke(Request $request){
        $client=$request->input('Client_list');

        $request->validate([
            'Ticket_name' => 'required|string|max:255',
             ], [
            'Ticket_name.required' => 'Il nome del ticket è obbligatorio.',
            ]);

        //CREO TICKET SU CLOCKIFY TRAMITE API POST
        // La chiave API
        $apiKey = env('API_KEY'); 

        // URL dell'API
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->withoutVerifying()->post('https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects', [
        'clientId' => $client,
        'name' => $request->Ticket_name,
        'color'=> '#689F38',  //ad ogni ticket creato (e aperto) assegno il colore verde (= ticket aperto)
        ]);
        //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)


        // Verifico se la chiamata ha avuto successo
        if ($response->successful()) {
            return redirect()->route('dashboard')->with('success', 'Ticket inserito correttamente!');
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
