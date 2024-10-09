<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Client;

class EditClient extends Controller
{
    public function __invoke(Request $request){
        $clientname=$request->input('clientname');

        //trovo il cliente sul database
        $client = Client::where('Ragione_Sociale', $clientname)->first()->toarray();

        return view ('EditClient', ['client'=>$client]);
    }
}
