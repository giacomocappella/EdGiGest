<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class EditTicket extends Controller
{
    public function __invoke(Request $request){
        
        $idticket=$request->input('idticket');
    
        //recupero il ticket da modificare
        $ticket = Ticket::join('clients', 'tickets.Partita_IVA_CF_Cliente', '=', 'Partita_IVA_CF')
            ->select('tickets.*', 'clients.Ragione_Sociale')
            ->where('tickets.id', $idticket)
            ->first();
           
        return view('EditTicket', ['ticket'=>$ticket]); 
        
    }
}
