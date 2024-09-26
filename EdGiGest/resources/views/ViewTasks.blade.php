<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Attività</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: auto;
        }
        h1, h2 {
            color: #333;
            text-align: center;
        }
        .DettagliTicket {
            background-color: #fafafa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .riga {
            margin-bottom: 10px;
            font-size: 16px;
        }
        .ColonnaBottoni {
            text-align: center;
            margin-top: 20px;
        }
        .bottoni {
            display: flex;
            justify-content: center; 
            gap: 10px; 
        }

        .bottoni button, .bottoni a {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            font-size: 16px;
            cursor: pointer;
        }
        .bottoni button:hover, .bottoni a:hover {
            background-color: #45a049;
        }
        .bottoni a {
            text-decoration: none;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table thead {
            background-color: #4CAF50;
            color: white;
        }
        .table th, .table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .table tr:hover {
            background-color: #f1f1f1;
        }
        .table input[type="radio"] {
            cursor: pointer;
        }
    </style>
    <script>
        function confermaChiusura() {
        let scelta = confirm("Vuoi inviare mail al cliente con il rapportino della lavorazione? Cliccando su annulla non verrà inviata la mail");

        if (scelta) {
            document.getElementById('formSiclose').submit();
        } else {
            document.getElementById('formNoclose').submit();
        }
        }  

        function confermaSospensione() {
        let scelta = confirm("Sei sicuro di voler sospendere il ticket?");

        if (scelta) {
            document.getElementById('formSisuspend').submit();
        } //altrimenti annulla
        }  
        function confermaRiapertura() {
        let scelta = confirm("Sei sicuro di voler riaprire il ticket?");

        if (scelta) {
            document.getElementById('formSiopen').submit();
        } //altrimenti annulla
        }   
        function confermaEliminazione() {
        let scelta = confirm("Sei sicuro di voler eliminare l'attività?");

        if (scelta) {
            document.getElementById('formSidelete').submit();
        } //altrimenti annulla
        }  
        
    </script>
</head>
<body>
    <div class="container">
        <h1>ELENCO ATTIVITÀ</h1>
        <h2>Ticket: {{$tickets['name']}}</h2>

        <div class="DettagliTicket">
            <div class="riga"><strong>Cliente:</strong> {{$tickets['clientName']}}</div>
            <div class="riga"><strong>Id:</strong> {{$tickets['id']}}</div>
            <div class="riga"><strong>Stato:</strong> 
                @if($tickets['color'] == '#689F38')
                    <span style="color: #4CAF50;">Aperto</span>
                @elseif($tickets['color'] == '#FF5722')
                    <span style="color: #FF5722;">Sospeso</span>
                @else
                    <span style="color: #FF0000;">Chiuso</span>
                @endif
            </div>
            <div class="riga"><strong>Ore svolte:</strong> {{$tickets['duration']}}</div>
        </div>

        <div class="ColonnaBottoni">
            <div class="bottoni">
                <button onclick="confermaChiusura()">Chiudi Ticket</button>
                <form id="formSiclose" action="{{ route('close.ticket.mail') }}" method="POST" style="display: none;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="idclose" value="{{ $tickets['id'] }}">
                    <input type="hidden" name="nameticket" value="{{ $tickets['name'] }}">
                    <input type="hidden" name="nameclient" value="{{ $tickets['clientName'] }}">
                </form>
                <form id="formNoclose" action="{{ route('close.ticket.nomail') }}" method="POST" style="display: none;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="idclose" value="{{ $tickets['id'] }}">
                </form>
                <button onclick="confermaSospensione()">Sospendi Ticket</button>
                <form id="formSisuspend" action="{{ route('suspend.ticket') }}" method="POST" style="display: none;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="idsuspend" value="{{ $tickets['id'] }}">
                </form>
                <button onclick="confermaRiapertura()">Riapri Ticket</button>
                <form id="formSiopen" action="{{ route('reopen.ticket') }}" method="POST" style="display: none;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="idreopen" value="{{ $tickets['id'] }}">
                </form>
                <a href='/'>Torna alla dashboard</a>
            </div>
        </div>

        <h2>LISTA ATTIVITÀ</h2>
        <table class="table">
            <form action="{{ route('create.task') }}" method="GET">
            @csrf
            <thead>
                <tr>
                    <th>Seleziona</th>
                    <th>Inizio attività</th>
                    <th>Fine attività</th>
                    <th>Durata</th>
                    <th>Descrizione</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td><input type="radio" name="idtask" value="{{$task['id']}}"></td>
                    <td>{{ $task['timeInterval']['start'] }}</td>
                    <td>{{ $task['timeInterval']['end'] }}</td>
                    <td>{{ $task['timeInterval']['duration'] }}</td>
                    <td>{{ $task['description'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="ColonnaBottoni">
            <div class="bottoni">           
                <input type="hidden" name="idticket" value="{{ $tickets['id'] }}">
                <button type="submit" formaction="{{ route('create.task') }}">Aggiungi attività</button>
                <button type="submit" formaction="{{ route('edit.task') }}">Modifica attività</button>
                <button type="submit" onclick="confermaEliminazione()" formaction="{{ route('delete.task') }}">Elimina attività</button>          
            </div>
        </div>
        </form>
    </div>
</body>
</html>
