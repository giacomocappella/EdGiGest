<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Client;
use App\Models\Ticket;

class Dashboard extends Controller
{
    public function __invoke()
    {
        //retrive dei ticket
        $groupedData = Ticket::join('clients', 'tickets.Partita_IVA_CF_Cliente', '=', 'clients.Partita_IVA_CF')
                                ->orderBy('clients.Ragione_Sociale', 'asc')
                                ->select('tickets.*', 'clients.Ragione_Sociale')
                                ->get()
                                ->groupBy('Ragione_Sociale'); // Raggruppa per nome cliente



        //conteggi
        $openTickets = Ticket::where('Stato', 'Aperto')->count();
        $pendingTickets = Ticket::where('Stato', 'Sospeso')->count();
        $clients=Client::count();
        

        // Passa i dati alla vista
        return view('Dashboard', ['groupedTickets' => $groupedData, 'openTicket' => $openTickets,  'pendingTicket' => $pendingTickets, 'totalclient' => $clients ]);

    }
}

