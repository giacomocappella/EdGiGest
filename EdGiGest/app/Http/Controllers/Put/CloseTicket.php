<?php

namespace App\Http\Controllers\Put;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\CloseTicketMail;
use App\Models\Client;

class CloseTicket extends Controller
{
    
    public function CloseNoMail(Request $request){
        
        //recupero tutti i dettagli del ticket
        $idticket=$request->input('idclose');

        
        $ticket=Ticket::findOrFail($idticket);

        $tasks=Task::where('Ticket_ID', $ticket->id)->orderBy('Data', 'asc')->get();

        //chiudo il ticket
        $ticket->Stato = 'Chiuso';
        $ticket->save();
   
        //chiudo e invio solo la mail a info
        Mail::to("info@edgitech.it")->send(new CloseTicketMail($ticket, $tasks));
        session(['idticket' => $idticket]);
        return redirect()->route('get.tasks');
            
    }
    public function CloseWithMail(Request $request){
        
        //recupero tutti i dettagli del ticket e dei task ad esso associati 
        $idticket=$request->input('idclose');

        $ticket = Ticket::where('id', $idticket)
        ->with('client') // Recupera i dati del cliente associato
        ->first();

        $tasks=Task::where('Ticket_ID', $ticket->id)->orderBy('Data', 'asc')->get();
        $emailTicket = $ticket->client->Mail_ticket;
    
        //chiudo il ticket
        $ticket->Stato = 'Chiuso';
        $ticket->save();
        
        Mail::to($emailTicket)
                ->bcc("info@edgitech.it") // Aggiunge info@edgitech.it in CCN
                ->send(new CloseTicketMail($ticket, $tasks));
 
        session(['idticket' => $idticket]);
        return redirect()->route('get.tasks');
         
    }
}
