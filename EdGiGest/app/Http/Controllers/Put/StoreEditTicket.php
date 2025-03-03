<?php

namespace App\Http\Controllers\Put;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class StoreEditTicket extends Controller
{
    public function __invoke(Request $request){
        
        $idticket=$request->input('idticket');

        $request->validate( [
            'Ticket_name.required' => 'Il nome del ticket è obbligatorio.',
            ]);

        //upload ticket
        Ticket::where('id', $idticket)->update(['Nome' => $request->Ticket_name]);

        session(['idticket' => $idticket]);
        return redirect()->route('get.tasks')->with('success', 'Ticket modificato correttamente!');
    }
}
