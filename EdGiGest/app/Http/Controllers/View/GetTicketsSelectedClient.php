<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Client;
use App\Models\User;

class GetTicketsSelectedClient extends Controller
{
    public function __invoke(Request $request){
        
        $idclient=$request->input('clientid');
       
        $tickets = Ticket::where('Partita_IVA_CF_Cliente', $idclient)->get();

        $client=Client::findOrFail($idclient);

        $users = User::where('current_team_id', '0000000000')->get();

        return view('NewReceipt', ['tickets'=>$tickets, 'idclient'=>$idclient, 'clientname'=>$client->Ragione_Sociale, 'users'=>$users]);
         
    }
}