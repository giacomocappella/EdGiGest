<!DOCTYPE html>
<html>
<head>
    <title>Rapportino Chiusura Ticket</title>
</head>
<body>
    <h1>Il tuo ticket è stato chiuso</h1>
    <p>Gentile cliente, con la presente vogliamo informare che sono terminate le attivià associate al ticket di cui riportiamo i dettagli qui sotto.</p><br>
    <h2>Nome ticket: {{ $nameticket }}</h2>
    <p>Dettagli attività eseguite</p>
    @foreach ($tasks as $task)
        <p><b>Inizio attività:</b> {{ $task['timeInterval']['start'] }}<br>
        <b>Fine attività:</b> {{ $task['timeInterval']['end'] }}<br>
        <b>Durata:</b> {{ $task['timeInterval']['duration'] }}<br>
        <b>Descrizione:</b> {{ $task['description'] }}</p><br>
    @endforeach
    <p>Rimaniamo a disposizione per eventuali chiarimenti.<br>
        Cordiali Saluti.
    </p>

    <p>EdGiTech - info@edgitech.it</p>
</body>
</html>