<?php

namespace App\Http\Controllers\Put;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Client;

class StoreEditClient extends Controller
{
    public function __invoke(Request $request){
        $request->validate([
            'Ragione_Sociale' => 'required|string|max:255',
            'Partita_IVA_CF' => 'required|string|max:16', 
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
            'Mail_amministrazione.required' => 'La Mail di amministrazione è obbligatoria.',
            'Mail_ticket.required' => 'La Mail per invio ticket è obbligatoria.', 
            'Contatto_telefonico.required' => 'Il Contatto telefonico è obbligatorio.', 
            'Via.required' => 'La Via è obbligatoria.',
            'Civico.required' => 'Il Civico è obbligatorio.',
            'Citta.required' => 'La Città è obbligatoria.',
            'Cap.required' => 'Il CAP è obbligatorio.', 
            'Provincia.required' => 'La Provincia è obbligatoria.',
        ]);

        
        //AGGIORNO  CLIENTE SU DATABASE
        $client= Client::where('Ragione_Sociale', $request->input('Ragione_Sociale'))->first();
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

        
        return redirect()->route('get.clients');

    }
}
