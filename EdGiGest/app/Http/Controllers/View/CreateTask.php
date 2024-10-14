<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateTask extends Controller
{
    public function __invoke(Request $request)
    {   
        //recupero l'id del ticket che serve per creare l'attività
        $idticket=$request->input('idticket');
        $nameticket=$request->input('nameticket');

        return view('NewTask',['idticket'=> $idticket, 'nameticket'=> $nameticket]);
    }
}
