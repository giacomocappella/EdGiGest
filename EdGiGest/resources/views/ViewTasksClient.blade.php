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


    </style>
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
                <a href="#" onclick="event.preventDefault(); window.history.back();" class="button-link">
                    <span class="material-icons-sharp">
                        arrow_back
                    </span>
                    <h3>Torna Indietro</h3>
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
        <br><br>
        <h2>Lista Attività</h2>
        <table class="table">
            <form action="{{ route('create.task') }}" method="GET">
            @csrf
            <thead>
                <tr>
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
                    <td>{{ \Carbon\Carbon::parse($task->Data)->format('d.m.Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->Ora_inizio)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->Ora_fine)->format('H:i') }}</td>
                    <td>{{ $task->Durata }} h</td>
                    <td>{{ $task->Descrizione }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</body>
</html>
