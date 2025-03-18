<!DOCTYPE html>
<html>
<head>
    <title>Report Chiusura Ticket</title>
    <style>
        .confidential-note {
            font-size: 10px;
            color: gray;
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Il tuo ticket è stato chiuso</h1>
    <p>Gentile cliente, con la presente vogliamo informare che sono terminate le attività associate al ticket di cui riportiamo i dettagli qui sotto.</p><br>
    
    <h2>Ticket #{{$ticket->id}}: {{ $ticket->Nome }}</h2>
    <p>Ore totali ticket: {{ number_format($ticket->Ore_totali, 2, ',', '.') }} h</p>
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

    <!-- Nota di riservatezza -->
    <p class="confidential-note">
        <b>Nota di riservatezza:</b> La presente comunicazione, unitamente alle informazioni in essa contenute e ogni documento o file allegato, è strettamente riservata e può contenere informazioni confidenziali. È rivolta unicamente ai destinatari cui è indirizzata e agli altri soggetti da questi autorizzati a riceverla.<br><br>

        Se non siete i destinatari/autorizzati siete avvisati che qualsiasi azione, copia, comunicazione, divulgazione o simili è vietata e potrebbe essere contro la legge.<br><br>

        Se avete ricevuto questa comunicazione per errore, vi preghiamo di darne immediata notizia al mittente ovvero di segnalare l’accaduto al seguente indirizzo email info@edgitech.it e di distruggere il messaggio originale e ogni file allegato senza farne copia o riprodurne in alcun modo il contenuto.<br><br>

        Ai sensi del Regolamento UE 679/2016 (GDPR), La informiamo che i nostri sistemi ed archivi comprendono recapiti relativi a persone fisiche, aziende, enti che hanno fornito gli stessi o con i quali sono intercorse precedenti comunicazioni. I dati saranno trattati solo dai nostri incaricati, debitamente autorizzati, e saranno conservati fino all’esaurirsi della finalità per cui sono stati raccolti. L’interessato potrà esercitare i diritti di cui agli Artt. 15 e ss del GDPR scrivendo al titolare del trattamento: Caregnato Edoardo – Cappella Giacomo, info@edgitech.it, caregnatoedoardo@pec.it - cappellagiacomo@pec.it. È possibile inoltre presentare un reclamo all’autorità Garante della Privacy ai sensi degli Artt. 77 e ss del GDPR.
    </p>

</body>
</html>
