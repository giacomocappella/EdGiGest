<?php

namespace App\Http\Controllers\Put;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReopenTicket extends Controller
{
    public function __invoke(Request $request){
        $apiKey = env('API_KEY'); 

        //recupero tutti i dettagli del ticket
        $idticket=$request->input('idreopen');

        //API - PUT
        $url="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects/$idticket";
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->withoutVerifying()->put($url, [
        'color'=> '#689F38',
        ]);
        //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)


        // Verifico se la chiamata ha avuto successo
        if ($response->successful()) {
            session(['idticket' => $idticket]);
            return redirect()->route('get.tasks');
            } 
        else {
            return response()->json([
                'error' => 'Request failed',
                'status' => $response->status(),
                'message' => $response->body(),
                ], $response->status());
        }
 
    }
}
