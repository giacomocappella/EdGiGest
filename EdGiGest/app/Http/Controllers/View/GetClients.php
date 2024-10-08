<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Client;

class GetClients extends Controller
{
    public function __invoke(){
        //recupero la lista dei clienti dal database
        $clients = Client::orderBy('Ragione_Sociale', 'asc')->pluck('Ragione_Sociale');; 
        return view('ViewClients', ['clients'=>$clients]);
    }
}
