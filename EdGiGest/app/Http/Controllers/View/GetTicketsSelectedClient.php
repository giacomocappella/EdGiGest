<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetTicketsSelectedClient extends Controller
{
    public function __invoke(Request $request){

    // La chiave API
    $apiKey = env('API_KEY'); 
    $idclient=$request->input('Client_list');

    //API PER RECUPERO TICKET
    $urlticket='https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects?client=$idclient';
    $responseticket = Http::withHeaders([
        'x-api-key' => $apiKey,
    ])->withoutVerifying()->get($urlticket);
    //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)
    
    if ($responseticket->successful()) {
        // Decodifica la risposta JSON
        $data = $responseticket->json();

        // Passa i dati alla vista

        return view('NewReceipt', ['tickets'=>$data]);
    } else {
        // Gestisci l'errore
        return response()->json(['error' => 'Unable to fetch data'], 500);
    }
  
}
}