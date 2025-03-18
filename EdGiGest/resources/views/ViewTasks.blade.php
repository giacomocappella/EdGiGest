<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Attività</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
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
            background-color: #006972;
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
            background-color: #007f8a;
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
            background-color: #006972;
            color: white;
        }
        .table th, .table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .table input[type="radio"] {
            cursor: pointer;
        }
        .form-container {
            width: 70%;
            max-width: 1000px;
            background-color: #fff;
            padding: 20px;
            margin: auto auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .aperto {
            color: green;
        }

        .sospeso {
            color: orange;
        }

        .chiuso {
            color: red;
        }
        .table td:nth-child(6) { 
        max-width: 500px; /* Aumenta la larghezza della colonna */
        word-wrap: break-word; /* Permette la rottura della parola se troppo lunga */
        white-space: pre-wrap; /* Mantiene la formattazione del testo */
        text-align: left; /* Allinea il testo a sinistra */
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
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="/logo.png">
                    <h2>EdGi<span class="danger">Gest</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                <a href="/">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>
                <a href="/newclient">
                    <span class="material-icons-sharp">
                        person_add
                    </span>
                    <h3>Nuovo Cliente</h3>
                </a>
                <a href="/client">
                    <span class="material-icons-sharp">
                        group
                    </span>
                    <h3>Lista Clienti</h3>
                </a>
                <a href="/newticket">
                    <span class="material-icons-sharp">
                        add
                    </span>
                    <h3>Nuovo Ticket</h3>
                </a>
                <a href="/newservice">
                    <span class="material-icons-sharp">
                        add_to_queue 
                    </span>
                    <h3>Nuovo Servizio</h3>
                </a>
                <a href="/ticket">
                    <span class="material-icons-sharp">
                        format_list_numbered
                    </span>
                    <h3>Lista Tickets</h3>
                </a>
                <a href="/newreceipt">
                    <span class="material-icons-sharp">
                        euro_symbol
                    </span>
                    <h3>Crea Ricevuta</h3>
                </a>
                <a href="/settings">
                    <span class="material-icons-sharp">
                        settings
                    </span>
                    <h3>Impostazioni</h3>
                </a>
                <a href="/profile" class="button-link sidebar-footer"> 
                    <span class="material-icons-sharp"> 
                        account_circle 
                    </span> 
                    <h3>{{ Auth::user()->name }}</h3>
                    
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="button-link">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>

    <div class="form-container">
        <h1>Ticket: {{$tickets->Nome}}</h1>

        <div class="DettagliTicket">
            <div class="riga"><strong>Cliente:</strong> {{$tickets->Ragione_Sociale}}</div>
            <div class="riga"><strong>Ticket # </strong> {{$tickets->id}}</div>
            <div class="riga">
                <strong>Stato: <span class="{{ strtolower($tickets->Stato) }}">{{ $tickets->Stato }}</span></strong>
            </div>         
            <div class="riga"><strong>Ore totali:</strong> {{ number_format($tickets->Ore_totali, 2, ',', '') }} h</div>
            <div class="riga"><strong>Tecnici impiegati:@if($tickets->Doppio_tecnico==1) 2 @else 1 @endif</strong></div>
        </div>
    
        <div class="ColonnaBottoni">
            <div class="bottoni">
                @if($tickets->Stato == 'Aperto'||$tickets->Stato == 'Sospeso')
                <form action="{{ route('edit.ticket') }}" method="GET">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="idticket" value="{{ $tickets->id }}">
                    <button type="submit">Modifica Ticket</button>
                </form>
                @endif
                @if($tickets->Stato == 'Aperto'||$tickets->Stato == 'Sospeso')
                    <button onclick="confermaChiusura()">Chiudi Ticket</button>
                    <form id="formSiclose" action="{{ route('close.ticket.mail') }}" method="POST" style="display: none;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="idclose" value="{{ $tickets->id }}">
                    </form>
                    <form id="formNoclose" action="{{ route('close.ticket.nomail') }}" method="POST" style="display: none;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="idclose" value="{{ $tickets->id }}">
                    </form>
                @endif
                @if($tickets->Stato == 'Aperto')
                    <button onclick="confermaSospensione()">Sospendi Ticket</button>
                    <form id="formSisuspend" action="{{ route('suspend.ticket') }}" method="POST" style="display: none;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="idsuspend" value="{{ $tickets->id }}">
                    </form>
                @endif
                @if($tickets->Stato == 'Sospeso'||$tickets->Stato == 'Chiuso')
                    <button onclick="confermaRiapertura()">Riapri Ticket</button>
                    <form id="formSiopen" action="{{ route('reopen.ticket') }}" method="POST" style="display: none;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="idreopen" value="{{ $tickets->id }}">
                    </form>
                @endif
            </div>
        </div>
        <br><br>
        <h2>Lista Attività</h2>
        <table class="table">
            <form action="{{ route('create.task') }}" method="GET">
            @csrf
            <thead>
                <tr>
                    <th>Seleziona</th>
                    <th>Data attività</th>
                    <th>Inizio attività</th>
                    <th>Fine attività</th>
                    <th>Durata</th>
                    <th>Descrizione</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td><input type="radio" name="idtask" value="{{$task->id}}"></td>
                    <td>{{ \Carbon\Carbon::parse($task->Data)->format('d.m.Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->Ora_inizio)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->Ora_fine)->format('H:i') }}</td>
                    <td>{{ $task->Durata }} h</td>
                    <td>{{ $task->Descrizione }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="ColonnaBottoni">
            @if($tickets->Stato == 'Aperto')
            <div class="bottoni">         
                <input type="hidden" name="idticket" value="{{ $tickets->id }}">
                <input type="hidden" name="nameticket" value="{{ $tickets->Nome }}">
                
                <button type="submit" formaction="{{ route('create.task') }}">Aggiungi attività</button>
                <button type="submit" formaction="{{ route('edit.task') }}">Modifica attività</button>
                <button type="submit" onclick="confermaEliminazione()" formaction="{{ route('delete.task') }}">Elimina attività</button>     
                   
            </div>
            @endif
        </div>
        </form>
    </div>
    </div>
</body>
</html>
