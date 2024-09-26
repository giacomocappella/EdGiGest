<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EditTask extends Controller
{
    public function reconvertDate($inputDate) {
        $date = new \DateTime($inputDate);
        return $date->format('Y-m-d\TH:i');
    }

    public function __invoke(Request $request)
    {
        $idtask=$request->input('idtask');
        $idticket=$request->input('idticket');
        //se non viene selezionata alcuna attività, rimani sulla pagina della lista attività
        if($idtask==null){
            session(['idticket' => $idticket]);
            return redirect()->route('get.tasks');
        }
           

        //recupero i dettagli del task selezionato e lo passo alla vista per la visualizzazione
        $apiKey = env('API_KEY'); 
        $urltask="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/time-entries/$idtask";
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
      ])->withoutVerifying()->get($urltask);
      //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)
        
      //VERIFICA DELLA CHIAMATA
      if ($response->successful()) {
        $datatask = $response->json();
        //ri-converto inizio e fine attività per la vista
        $datatask['timeInterval']['start']=$this->reconvertDate($datatask['timeInterval']['start']);
        $datatask['timeInterval']['end']=$this->reconvertDate($datatask['timeInterval']['end']);
        return view('EditTask', ['task'=>$datatask , 'idticket'=>$idticket]);

      } else {
          
          return response()->json(['error' => 'Unable to fetch data'], 500);
        
    }
        
    }
}
