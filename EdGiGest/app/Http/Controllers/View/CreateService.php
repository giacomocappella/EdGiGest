<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Client;

class CreateService extends Controller
{
    public function __invoke(){

        $clients = Client::select([
            'Ragione_Sociale',
            'Partita_IVA_CF',
        ])->get(); 
        return view('NewService', ['items'=>$clients]);  
    }
}
