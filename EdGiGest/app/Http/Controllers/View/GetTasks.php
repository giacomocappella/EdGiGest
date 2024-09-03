<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetTasks extends Controller
{
    public function __invoke(Request $request)
    {
        //recupero tutti i dettagli del ticket
        $idticket=$request->input('id');
        //salvo in sessione l'id del ticket che serve per creare le nuove attività o modificarle
        session(['idticket'=>$idticket]);
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

        //creo i vettori per la sistemazione dell'orario effetuato
        
      //VERIFICA DELLA CHIAMATA
      if ($response->successful()) {
         $datatask = $response->json();
         foreach ($datatask as &$task) {
            
            if ($task['duration'] === null || $task['duration'] === "PT0S") {
                $task['duration'] = "0";
            } else {
                
                preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?/', $task['duration'], $matches);
        
                $ore = isset($matches[1]) ? $matches[1] . ' h ' : '';
                $minuti = isset($matches[2]) ? $matches[2] . ' min ' : '';
        
                
                $task['duration'] = trim($ore . $minuti);
            }
        }
        
        return view('ViewTasks', ['tasks'=>$datatask], ['tickets'=>$dataticket]);

      } else {
          
          return response()->json(['error' => 'Unable to fetch data'], 500);
        
    }
}
}