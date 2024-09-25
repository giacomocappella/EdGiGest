<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use App\Models\Client;

class Dashboard extends Controller
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
    
    public function __invoke()
    {
        // La chiave API
        $apiKey = env('API_KEY'); 

        // URL dell'API
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
      ])->withoutVerifying()->get('https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects?sort-column=CLIENT_NAME');
      //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)


      // Verifica se la chiamata ha avuto successo
      if ($response->successful()) {
          // Decodifica la risposta JSON
          $data = $response->json();

        //converto le durate
        foreach ($data as &$ticket) {
            $ticket['duration']=$this->convertDurationFormat($ticket['duration']);
        }
   
        //filtro solo i ticket aperti o sospesi in base al colore
          $filteredData = collect($data)->filter(function($ticket) {
            // Filtra solo i ticket aperti o sospesi, escludendo quelli chiusi
            return in_array($ticket['color'], ['#689F38', '#FF5722']);
        });

        // Raggruppa i dati filtrati per `clientName`
        $groupedData = $filteredData->groupBy('clientName');
        
        //Conteggio dei ticket aperti
        $openTickets = 0;
        $pendingTickets=0;

        foreach ($groupedData as $clientName => $tickets) {
            foreach ($tickets as $ticket) {
                if ($ticket['color'] == '#689F38') {
                    $openTickets++;
                } elseif ($ticket['color'] == '#FF5722') {
                    $pendingTickets++;
                }
            }
      }

      $clients=Client::count();

       // Passa i dati alla vista
       return view('Dashboard', ['groupedTickets' => $groupedData, 'openTicket' => $openTickets,  'pendingTicket' => $pendingTickets, 'totalclient' => $clients ]);
    }else {
          // Gestisci l'errore
          return response()->json(['error' => 'Unable to fetch data'], 500);
      }
    }
}

