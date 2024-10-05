<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetTicketsSelectedClient extends Controller
{
    public function convertDurationFormat($duration)
    {
        if ($duration === null || $duration === "PT0S") {
            $duration = "0 h";
        } else {
            
            preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?/', $duration, $matches);
    
            $ore = isset($matches[1]) ? $matches[1] . ' h ' : '';
            $minuti = isset($matches[2]) ? $matches[2] . ' min ' : '';
    
            
            $duration = trim($ore . $minuti);

            
        }
        return $duration;
    }

    public function __invoke(Request $request){

    // La chiave API
    $apiKey = env('API_KEY'); 
    $idclient=$request->input('clientid');

    //API PER RECUPERO TICKET
    $urlticket="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects?clients=$idclient";
    $responseticket = Http::withHeaders([
        'x-api-key' => $apiKey,
    ])->withoutVerifying()->get($urlticket);
    //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)
    
    if ($responseticket->successful()) {
        // Decodifica la risposta JSON
        $data = $responseticket->json();
        foreach ($data as &$ticket) {
            $ticket['duration']=$this->convertDurationFormat($ticket['duration']);
        }

        // Passa i dati alla vista

        return view('NewReceipt', ['tickets'=>$data, 'idclient'=>$idclient]);
    } else {
        // Gestisci l'errore
        return response()->json(['error' => 'Unable to fetch data'], 500);
    }
  
}
}