<?php

namespace App\Http\Controllers\Put;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\CloseTicketMail;
use App\Models\Client;

class CloseTicket extends Controller
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
            $duration = "0 h";
        } else {
            
            preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?/', $duration, $matches);
    
            $ore = isset($matches[1]) ? $matches[1] . ' h ' : '';
            $minuti = isset($matches[2]) ? $matches[2] . ' min ' : '';
    
            
            $duration = trim($ore . $minuti);

            
        }
        return $duration;
    }

    public function CloseNoMail(Request $request){
        $apiKey = env('API_KEY'); 

        //recupero tutti i dettagli del ticket
        $idticket=$request->input('idclose');
   
        //API - PUT
        $url="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects/$idticket";
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->withoutVerifying()->put($url, [
        'color'=> '#FF0000',
        ]);
        //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)

        // Verifico se la chiamata ha avuto successo
        if ($response->successful()) {
            session(['idticket' => $idticket]);
            return redirect()->route('dashboard');
            } 
        else {
            return response()->json([
                'error' => 'Request failed',
                'status' => $response->status(),
                'message' => $response->body(),
                ], $response->status());
        }
    }
    public function CloseWithMail(Request $request){
        $apiKey = env('API_KEY'); 

        //recupero tutti i dettagli del ticket e dei task ad esso associati 
        $idticket=$request->input('idclose');
        $nameticket=$request->input('nameticket');
        $nameclient=$request->input('nameclient');

        //recupero mail ticket del cliente per invio rapportino
        $client=Client::where('Ragione_Sociale',$nameclient)->first();
        if($client)
            $clientmail=$client->Mail_ticket;
        else
            echo "Cliente non trovato.";

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

            } else {
            
            return response()->json(['error' => 'Unable to fetch data'], 500);
            
        }

        //API - CHIUDI TICKET
        $url="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects/$idticket";
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->withoutVerifying()->put($url, [
        'color'=> '#FF0000',
        ]);
        //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)


        // Verifico se la chiamata ha avuto successo
        if ($response->successful()) {
            //se l'api ha successo, il sistema invia la mail 
            Mail::to($clientmail)->send(new CloseTicketMail($nameticket, $datatask));
            return redirect()->route('dashboard');
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
