<!DOCTYPE html>
<html>
<head>
    <title>Report Chiusura Ticket</title>
</head>
<body>
    <h1>Il tuo ticket è stato chiuso</h1>
    <p>Gentile cliente, con la presente vogliamo informare che sono terminate le attività associate al ticket di cui riportiamo i dettagli qui sotto.</p><br>
    <h2>Ticket #{{$ticket->id}}: {{ $ticket->Nome }}</h2>
    <p>Ore totali ticket: {{$ticket->Ore_totali}}</p>
    <p>Dettagli attività eseguite:</p>
    @foreach ($tasks as $task)
        <p><b>Data attività:</b> {{ \Carbon\Carbon::parse($task->Data)->format('d.m.Y') }}<br>
        <b>Inizio attività:</b> {{ \Carbon\Carbon::parse($task->Ora_inizio)->format('H:i') }}<br>
        <b>Fine attività:</b> {{ \Carbon\Carbon::parse($task->Ora_fine)->format('H:i') }}<br>
        <b>Tecnici impiegati:</b> @if($ticket->Doppio_tecnico==1) 2 @else 1 @endif<br>
        <b>Durata:</b> {{ $task->Durata }}<br>
        <b>Descrizione:</b> {{ $task->Descrizione }}</p><br>
    @endforeach
    <p>Rimaniamo a disposizione per eventuali chiarimenti.<br>
        Cordiali Saluti.
    </p>

    <p>EdGiTech - info@edgitech.it</p>
</body>
</html>