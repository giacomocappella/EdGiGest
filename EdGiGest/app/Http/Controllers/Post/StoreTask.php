<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StoreTask extends Controller
{
    public function __invoke(Request $request, $idticket)
    {
        $request->validate([
            'Task_name' => 'required|string|max:255',
             ], [
            'Task_name.required' => 'Il nome dell\'attività è obbligatorio.',
            ]);

        //CREO TASK SU CLOCKIFY TRAMITE API POST
        // La chiave API
        $apiKey = env('API_KEY'); 

        // URL dell'API
        $urltask="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects/$idticket/tasks";
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->withoutVerifying()->post($urltask, [
        'name' => $request->Task_name,
        ]);
        //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)


        // Verifico se la chiamata ha avuto successo
        if ($response->successful()) {
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

