<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MakePDF extends Controller
{
        public function __invoke(Request $request){
            $tickets=$request->input('selected_tickets');

            //recupero l'id client per recuperare i dati dal database
            $idclient=$request->input('idclient');
            
            //recupero il nome del cliente da clickify (serve per la ricerca dei dati dal database)
            $apiKey = env('API_KEY'); 
            $urlclient="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/clients/$idclient";
    
            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
            ])->withoutVerifying()->get($urltask);
            //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)

            if ($response->successful()) {
                $client = $response->json();
                
                } 
            else {
                return response()->json([
                    'error' => 'Request failed',
                    'status' => $response->status(),
                    'message' => $response->body(),
                    ], $response->status());
            }
            //dd($client);
            foreach ($tickets as $ticketData) {
                $ticketArray = explode(',', $ticketData);
            
                $ticketsArray[]= [
                    'id' => $ticketArray[0],
                    'name' => $ticketArray[1],
                    'duration' => $ticketArray[2],
                ];
            }

            $pdf = Pdf::loadView('ReceiptPDF', compact('ticketsArray'));

            return $pdf->download('receipt.pdf');


        }
    

}
