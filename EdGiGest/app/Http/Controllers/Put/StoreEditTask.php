<?php

namespace App\Http\Controllers\Put;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Task;

class StoreEditTask extends Controller
{

    public function __invoke(Request $request)
    {
        //recupero l'id del ticket e del task
        $idticket=$request->input('idticket');
        $idtask=$request->input('idtask');

        $request->validate([
            'Task_Date' => 'required|date_format:Y-m-d',
            'Task_Start' => 'required|date_format:H:i',
            'Task_End' => 'required|date_format:H:i|after:Task_Start',
            'Description' => 'required|string|max:3000',
        ], [
            'Task_Date.required' => 'La data dell\'attività è obbligatoria.',
            'Task_Date.date_format' => 'Il formato della data non è valido.',
        
            'Task_Start.required' => 'L\'orario di inizio attività è obbligatorio.',
            'Task_Start.date_format' => 'Il formato dell\'orario di inizio non è valido.',
        
            'Task_End.required' => 'L\'orario di fine attività è obbligatorio.',
            'Task_End.date_format' => 'Il formato dell\'orario di fine non è valido.',
            'Task_End.after' => 'L\'orario di fine non può essere precedente all\'orario di inizio.',
        
            'Description.required' => 'La descrizione dell\'attività è obbligatoria.',
            'Description.string' => 'La descrizione deve essere un testo.',
            'Description.max' => 'La descrizione non può superare i 3000 caratteri.',
        ]);
        
        //recupero il ticket
        $ticket = Ticket::findOrFail($idticket);

        //recupero il task
        $task = Task::findOrFail($idtask);

        //calcolo le ore utilizzate
        $start = Carbon::parse($request->Task_Date . ' ' . $request->Task_Start);
        $end = Carbon::parse($request->Task_Date . ' ' . $request->Task_End);
        
        $task->Data = $request->Task_Date;
        $task->Ora_inizio = $request->Task_Start;
        $task->Ora_fine   = $request->Task_End;
        $task->Descrizione = $request->Description;

        $olddurationticket=$ticket->Ore_totali;
        $olddurationtask=$task->Durata;
        $tech=$ticket->Doppio_tecnico;

        //Aggiornamento della durata su task e ticket
        if($tech==1)
        {
            $ore_task = $start->diffInMinutes($end) / 60 *2;
            $task->Durata=$ore_task; 
        }
          
        else
        {
            $ore_task = $start->diffInMinutes($end) / 60; 
            $task->Durata=$ore_task;
        }
          
        //aggiornamento della durata sul ticket
        $ticket->Ore_totali=$olddurationticket-$olddurationtask+$task->Durata;

        $ticket->save();
        $task->save();
        
        session(['idticket' => $idticket]);
        return redirect()->route('get.tasks')->with('success', 'Attività inserita correttamente!');
                    
    }
}

