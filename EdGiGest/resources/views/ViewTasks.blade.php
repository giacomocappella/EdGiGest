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
                <div class="riga">Stato: @if($tickets['color']=='#8bc34a')
                                            Aperto
                                        @elseif($tickets['color']=='#ff8000')
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
            <th>Nome attività</th>
            <th>Durata</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
        <tr>
            <td><input type="radio" name="idtask" value="{{$task['id']}}" ></td>
            <td>{{ $task['name'] }}</td>
            <td>{{ $task['duration'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
    <a href="/newtask">Crea nuova attività</button>
</form>
</body>

