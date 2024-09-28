<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EditTicket extends Controller
{
    public function __invoke(Request $request){
        
        $idticket=$request->input('idticket');
        
        //recupero il ticket da modificare
        $apiKey = env('API_KEY'); 
        $urlticket="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects/$idticket";
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->withoutVerifying()->get($urlticket);
        //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)
        
        //VERIFICA DELLA CHIAMATA
        if ($response->successful()) {
            $datatask = $response->json();
            
            return view('EditTicket', ['ticket'=>$datatask]);
        } 
        else {
          
          return response()->json(['error' => 'Unable to fetch data'], 500);
        
        }

    }
}
