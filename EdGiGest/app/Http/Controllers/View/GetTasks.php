<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Task;

class GetTasks extends Controller
{
    public function __invoke(Request $request)
    {
        //recupero tutti i dettagli del ticket
        if($request->input('idticket')==null)
            $idticket = session('idticket'); //quando arrivo dalle pagine dei task
        else
            $idticket=$request->input('idticket');  //quando arrivo dalla lista ticket

        //recupero il ticket
        $dataticket = Ticket::join('clients', 'tickets.Partita_IVA_CF_Cliente', '=', 'Partita_IVA_CF')
            ->select('tickets.*', 'clients.Ragione_Sociale')
            ->where('tickets.id', $idticket)
            ->first();



        //recupero i task
        $datatask = Task::where('Ticket_ID', $idticket)
        ->orderBy('Data', 'asc')
        ->get();

        return view('ViewTasks', ['tasks'=>$datatask], ['tickets'=>$dataticket]);

    }
}