<?php

namespace App\Http\Controllers\Put;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class ReopenTicket extends Controller
{
    public function __invoke(Request $request){
        
        //recupero tutti i dettagli del ticket
        $idticket=$request->input('idreopen');

        $ticket=Ticket::findOrFail($idticket);

        $ticket->Stato = 'Aperto';
        $ticket->save();
        
        session(['idticket' => $idticket]);
        return redirect()->route('get.tasks');
           
 
    }
}
