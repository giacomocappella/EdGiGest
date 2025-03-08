<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\User;
use App\Models\Client;
use App\Models\Ticket;

class DashboardClient extends Controller
{
    public function __invoke(){
        //retrive dei ticket
        $user = Auth::user();

        $clientname = DB::table('clients')
                ->where('Partita_IVA_CF', $user->current_team_id)
                ->value('Ragione_Sociale');

        $groupedData = Ticket::join('clients', 'tickets.Partita_IVA_CF_Cliente', '=', 'clients.Partita_IVA_CF')
            ->where('tickets.Partita_IVA_CF_Cliente', $user->current_team_id) 
            ->select('tickets.*', 'clients.Ragione_Sociale')
            ->get();

            
       

        // Passa i dati alla vista
        return view('DashboardClient', ['groupedTickets' => $groupedData, 'clientname'=>$clientname]);

    }
}
