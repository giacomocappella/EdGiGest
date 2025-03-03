<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Task;

class EditTask extends Controller
{
    public function __invoke(Request $request)
    {
        $idtask=$request->input('idtask');
        $idticket=$request->input('idticket');
        //se non viene selezionata alcuna attività, rimani sulla pagina della lista attività
        if($idtask==null){
            session(['idticket' => $idticket]);
            return redirect()->route('get.tasks');
        }

        //recupero il task selezionato 
        $datatask=Task::find($idtask);

        $dataticket=Ticket::find($idticket);

        return view('EditTask', ['task'=>$datatask, 'tickets'=>$dataticket, 'idticket'=>$idticket]);
        
        
    }
}
