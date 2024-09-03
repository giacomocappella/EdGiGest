<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
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

          // Passa i dati alla vista
          return view('Dashboard', ['tickets'=>$data]);
      } else {
          // Gestisci l'errore
          return response()->json(['error' => 'Unable to fetch data'], 500);
      }
    }
}
