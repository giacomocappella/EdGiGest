<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CreateReceipt extends Controller
{
    public function __invoke(){

        //Recupero dall'ambiente la chiave di sicurezza
        //per poter effettuare la chiamata API
        $apiKey = env('API_KEY'); 

        //Definisco l'URI per la chiamata API
        $urlclient='https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/clients';

        //Chiamata API a Clockify con chiave e URI appena definiti
        $responseclient = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->withoutVerifying()->get($urlclient);
      

        // Verifico se la chiamata ha avuto successo
        if ($responseclient->successful()) {
            //Interpreto il risultato e lo inserisco nella variabile dataclient
            $dataclient = $responseclient->json();
            
            // Passa i clienti recuperati alla view
            return view('NewReceipt', ['client'=>$dataclient]);

        //Altrimenti gestisco l'errore
        } else {
              return response()->json(['error' => 'Unable to fetch data'], 500);
        }
    
    }
}
