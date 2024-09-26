<?php

namespace App\Http\Controllers\Delete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeleteTask extends Controller
{
    public function __invoke(Request $request)
    {
        //recupero dettagli ticket e attività
        $idtask=$request->input('idtask');
        $idticket=$request->input('idticket');
        
        //se non viene selezionata alcuna attività, rimani sulla pagina della lista attività
        if($idtask==null){
            session(['idticket' => $idticket]);
            return redirect()->route('get.tasks');
        }
           
        $apiKey = env('API_KEY'); 
        $urltask="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/time-entries/$idtask";
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
         ])->withoutVerifying()->delete($urltask);
        //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)
        
      //VERIFICA DELLA CHIAMATA
      if ($response->successful()) {
        $datatask = $response->json();
        return redirect()->route('get.tasks')->with('idticket', $idticket);

      } else {
          
          return response()->json(['error' => 'Unable to fetch data'], 500);
        
    }
        
    }
}
