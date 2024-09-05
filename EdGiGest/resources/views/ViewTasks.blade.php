<head>
    <title>Elenco Attività</title>
    
</head>
<body>
    <div>
        <h1>ELENCO ATTIVITA'</h1>
        <h2>Ticket: {{$tickets['name']}}</h2>
        <div class="container">
            <div class="DettagliTicket">
                <div class="riga">Cliente: {{$tickets['clientName']}}</div>
                <div class="riga">Id: {{$tickets['id']}}</div>
                <div class="riga">Stato: @if($tickets['color']=='#689F38')
                                            Aperto
                                        @elseif($tickets['color']=='#FF5722')
                                            Sospeso
                                        @else
                                            Chiuso
                                        @endif</div>
      
    </div>
    <br>
    <div class="ColonnaBottoni">
        <div class="bottoni">
            <button>Chiudi Ticket</button>
            <button>Riapri Ticket</button>
            <a href='/tickets'>Torna a elenco tickets</a>
        </div>
    </div>
</div>
</div>  
 <h2> LISTA ATTIVITA'</h2>
 <table class="table">
    <thead>
        <tr>
            <th></th>
            <th>Inizio attività</th>
            <th>Fine attività</th>
            <th>Durata</th>
            <th>Descrizione</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td><input type="radio" name="idtask" value="{{$task['id']}}" ></td>
            <td>{{ $task['timeInterval']['start'] }}</td>
            <td>{{ $task['timeInterval']['end'] }}</td>
            <td>{{ $task['timeInterval']['duration'] }}</td>
            <td>{{ $task['description'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>

