<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class GetTasks extends Controller
{
    public function convertDateFormat($dataora)
    {
    
    // Crea un'istanza Carbon dalla stringa della data
    $data = Carbon::parse($dataora);

    // Format the date
    $formattedDate = $data->format('d-m-Y H:i');

    return $formattedDate; 
    }

    public function convertDurationFormat($duration)
    {
        if ($duration === null || $duration === "PT0S") {
            $duration = "0 min";
        } else {
            
            preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?/', $duration, $matches);
    
            $ore = isset($matches[1]) ? $matches[1] . ' h ' : '';
            $minuti = isset($matches[2]) ? $matches[2] . ' min ' : '';
    
            
            $duration = trim($ore . $minuti);

            return $duration;
        }
    
    }

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

        //recupero tutti i task relativi al task
       
        $urltask="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/user/66b9e18097ddfb5029a6f6a4/time-entries?project=$idticket";
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
      ])->withoutVerifying()->get($urltask);
      //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)
        
      //VERIFICA DELLA CHIAMATA
      if ($response->successful()) {
        $datatask = $response->json();
        
         foreach ($datatask as &$task) {
            $task['timeInterval']['start']=$this->convertDateFormat($task['timeInterval']['start']);
            $task['timeInterval']['end']=$this->convertDateFormat($task['timeInterval']['end']);
            $task['timeInterval']['duration']=$this->convertDurationFormat($task['timeInterval']['duration']);
        }

        return view('ViewTasks', ['tasks'=>$datatask], ['tickets'=>$dataticket]);

      } else {
          
          return response()->json(['error' => 'Unable to fetch data'], 500);
        
    }
}
}