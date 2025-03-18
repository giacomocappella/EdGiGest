<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class StoreService extends Controller
{
    public function __invoke(Request $request){
        $client=$request->input('Client_list');

        $request->merge([
            'Amount_service' => str_replace(',', '.', $request->input('Amount_service'))
        ]);

        $request->validate([
            'Service_name' => 'required|string|max:255',
            'Amount_service' => 'required|numeric|min:0',
             ], [
            'Service_name.required' => 'Il nome del servizio è obbligatorio.',
            'Amount_service' => 'L\'ammontare del servizio è obbligatorio.',
            ]);
            $ticket=new Ticket();
            $ticket->Nome=$request->Service_name;
            $ticket->Partita_IVA_CF_Cliente=$request->input('Client_list');
            $ticket->Ore_totali=bcdiv($request->Amount_service, 30, 10);            
            $ticket->Stato="Chiuso";
            $ticket->Rendicontato=0;
            $ticket->Doppio_tecnico=0;
    
            $ticket->save();
            
            return redirect()->route('create.service')->with('success', 'Ticket inserito correttamente!');
            
    }
}
