<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class StoreTicket extends Controller
{
    public function __invoke(Request $request){
        $client=$request->input('Client_list');

        $request->validate([
            'Ticket_name' => 'required|string|max:255',
             ], [
            'Ticket_name.required' => 'Il nome del ticket è obbligatorio.',
            ]);
            $ticket=new Ticket();
            $ticket->Nome=$request->Ticket_name;
            $ticket->Partita_IVA_CF_Cliente=$request->input('Client_list');
            $ticket->Ore_totali=0;
            $ticket->Stato="Aperto";
            $ticket->Rendicontato=0;
            $ticket->Doppio_tecnico=$request->has('Doppio_Tecnico');
    
            $ticket->save();
            
            return redirect()->route('create.task',['idticket'=>$ticket->id, 'nameticket'=>$ticket->Nome, 'tech'=>$ticket->Doppio_tecnico])->with('success', 'Ticket inserito correttamente!');
            
    }
}
