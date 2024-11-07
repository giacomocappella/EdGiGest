<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Client;


class StoreClient extends Controller
{
    public function __invoke(Request $request){
        $request->validate([
            'Ragione_Sociale' => 'required|string|max:255',
            'Partita_IVA_CF' => 'required|string|max:16|unique:clients,Partita_IVA_CF', 
            'Mail_amministrazione' => 'required|email',
            'Mail_ticket' => 'required|email', 
            'Contatto_telefonico' => 'required|string|max:20', 
            'Via' => 'required|string|max:255',
            'Civico' => 'required|string|max:10',
            'Citta' => 'required|string|max:255',
            'Cap' => 'required|string|min:5|max:5', 
            'Provincia'=>'required|string|max:255',
             ], [
            'Ragione_Sociale.required' => 'La Ragione Sociale è obbligatoria.',
            'Partita_IVA_CF.required' => 'La Partita IVA o Codice Fiscale è obbligatoria.',
            'Partita_IVA_CF.unique' => 'La Partita IVA inserita è già presente nel sistema.',
            'Mail_amministrazione.required' => 'La Mail di amministrazione è obbligatoria.',
            'Mail_ticket.required' => 'La Mail per invio ticket è obbligatoria.', 
            'Contatto_telefonico.required' => 'Il Contatto telefonico è obbligatorio.', 
            'Via.required' => 'La Via è obbligatoria.',
            'Civico.required' => 'Il Civico è obbligatorio.',
            'Citta.required' => 'La Città è obbligatoria.',
            'Cap.required' => 'Il CAP è obbligatorio.', 
            'Provincia.required' => 'La Provincia è obbligatoria.',
        ]);

        //CREO CLIENTE SU DATABASE
        $client=new Client();
        $client->Ragione_Sociale=$request->Ragione_Sociale;
        $client->Partita_IVA_CF=$request->Partita_IVA_CF;
        $client->Mail_amministrazione=$request->Mail_amministrazione;
        $client->Mail_ticket=$request->Mail_ticket;
        $client->Contatto_telefonico=$request->Contatto_telefonico;
        $client->Via=$request->Via;
        $client->Civico=$request->Civico;
        $client->Citta=$request->Citta;
        $client->Cap=$request->Cap;
        $client->Provincia=$request->Provincia;

        $client->save();

        //CREO CLIENTE SU CLOCKIFY TRAMITE API POST
        // La chiave API
        $apiKey = env('API_KEY'); 

        // URL dell'API
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
      ])->withoutVerifying()->post('https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/clients', [
        'name' => $request->Ragione_Sociale,
        'email' => $request->Mail_ticket,
        'address' => $request->Via.' '.$request->Civico.', '.$request->Cap.' '.$request->Citta.', '.$request->Provincia,
      ]);
      //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)


      // Verifico se la chiamata ha avuto successo
    if ($response->successful()) {
        return redirect()->route('create.client')->with('success', 'Cliente inserito correttamente!');
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