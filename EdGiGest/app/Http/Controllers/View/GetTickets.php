<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class GetTickets extends Controller
{
    public function __invoke(Request $request){
          
        $tickets = Ticket::join('clients', 'tickets.Partita_IVA_CF_Cliente', '=', 'clients.Partita_IVA_CF')
                    ->select('tickets.*', 'clients.Ragione_Sociale as Ragione_Sociale') 
                    ->orderBy('clients.Ragione_Sociale', 'asc') 
                    ->orderBy('tickets.created_at', 'desc')
                    ->get();

        return view('ViewTickets', ['tickets'=>$tickets]);
        
    }
 }

