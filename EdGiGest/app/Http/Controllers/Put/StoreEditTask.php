<?php

namespace App\Http\Controllers\Put;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StoreEditTask extends Controller
{

    public function convertDate($inputDate) {
        $date = \DateTime::createFromFormat('Y-m-d\TH:i', $inputDate);
        return $date->format('Y-m-d\TH:i:s\Z');
    }

    public function __invoke(Request $request)
    {
        //recupero l'id del ticket e del task
        $idticket=$request->input('idticket');
        $idtask=$request->input('idtask');

        $request->validate([
            'Task_Start' => 'required|date_format:Y-m-d\TH:i',
            'Task_End' => 'required|date_format:Y-m-d\TH:i|after:Task_Start',
            'Description' => 'required|string|max:3000',
                ], [
            'Task_Start.required' => 'La data e l\'ora di inizio attività sono obbligatori.',
            'Task_End.required' => 'La data e l\'ora di inizio attività sono obbligatori.',
            'Task_End.after' => 'La data e l\'ora inseriti non possono essere precedenti a quelli di inzio attività.',
            'Description.required' => 'La descrizione dell\'attività è obbligatoria.'
            ]);
        
        //converto le date per adattarle a quelle richieste in clockify
        $request->Task_Start=$this->convertDate($request->Task_Start);
        $request->Task_End=$this->convertDate($request->Task_End);
    
        //CREO TASK SU CLOCKIFY TRAMITE API POST
        // La chiave API
        $apiKey = env('API_KEY'); 
        // URL dell'API
        $urltask="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/time-entries/$idtask";
    
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->withoutVerifying()->put($urltask, [
        'start' => $request->Task_Start,
        'end' => $request->Task_End,
        'description' => $request->Description,
        'projectId' => $idticket,
        ]);
        //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)


        // Verifico se la chiamata ha avuto successo
        if ($response->successful()) {
            session(['idticket' => $idticket]);
            return redirect()->route('get.tasks')->with('success', 'Attività inserita correttamente!');
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

