<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CreateReceipt extends Controller
{
    public function __invoke(){

        // La chiave API
        $apiKey = env('API_KEY'); 

        //API PER RECUPERO CLIENTI
        $urlclient='https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/clients';
        $responseclient = Http::withHeaders([
            'x-api-key' => $apiKey,
      ])->withoutVerifying()->get($urlclient);
      //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)

      // Verifica se la chiamata ha avuto successo
      if ($responseclient->successful()) {
            $dataclient = $responseclient->json();
            
          // Passa i dati alla vista
          return view('NewReceipt', ['client'=>$dataclient]);
      } else {
          // Gestisci l'errore
          return response()->json(['error' => 'Unable to fetch data'], 500);
      }
    
    }
}
