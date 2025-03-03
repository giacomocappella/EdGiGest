<?php

namespace App\Http\Controllers\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;

class CreateTask extends Controller
{
    public function __invoke(Request $request)
    {   
        //recupero l'id del ticket che serve per creare l'attività
        $idticket=$request->input('idticket');
        
        //recupero il ticket associato
        $ticket=Ticket::find($idticket);

        return view('NewTask',['idticket'=> $idticket, 'tickets'=>$ticket]);
    }
}
