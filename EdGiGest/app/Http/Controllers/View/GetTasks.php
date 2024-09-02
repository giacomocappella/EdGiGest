<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetTasks extends Controller
{
    public function __invoke($idticket)
    {
        //recupero tutti i dettagli del ticket
        $apiKey = env('API_KEY'); 
        $urlticket="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects/$idticket";
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
      ])->withoutVerifying()->get($urlticket);
        if ($response->successful()) {
            $dataticket = $response->json();
        } else {
            return response()->json(['error' => 'Unable to fetch tickets data'], 500);
        }

        //recupero tutti i task relativi al ticket
       
        $urltask="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects/$idticket/tasks";
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
      ])->withoutVerifying()->get($urltask);
      //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)

      //VERIFICA DELLA CHIAMATA
      if ($response->successful()) {
         $datatask = $response->json();
        return view('ViewTasks', ['tasks'=>$datatask], ['tickets'=>$dataticket]);

      } else {
          
          return response()->json(['error' => 'Unable to fetch data'], 500);
        
    }
}
}