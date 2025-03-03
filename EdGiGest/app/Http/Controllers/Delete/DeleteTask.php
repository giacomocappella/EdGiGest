<?php

namespace App\Http\Controllers\Delete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class DeleteTask extends Controller
{
    public function __invoke(Request $request)
    {
        //recupero dettagli ticket e attività
        $idtask=$request->input('idtask');
        $idticket=$request->input('idticket');

        //se non viene selezionata alcuna attività, rimani sulla pagina della lista attività
        if($idtask==null){
            session(['idticket' => $idticket]);
            return redirect()->route('get.tasks');
        }
           
        $task = Task::findOrFail($idtask);
        $task->delete();        

        session(['idticket' => $idticket]);     
        return redirect()->route('get.tasks')->with('idticket', $idticket); 
    }
}
