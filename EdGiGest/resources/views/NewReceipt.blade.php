<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Ricevuta</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css"> <!-- Assicurati che questo link punti al tuo file CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .submit-btn, .cancel-btn {
            background-color: #006972;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
            text-align: center;
        }

        .submit-btn:hover, .cancel-btn:hover {
            background-color: #007f8a;
        }
        .table-container {
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        table td {
            background-color: #fff;
        }

        .riga {
            margin-bottom: 10px;
            font-size: 16px;
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
                <a href="#">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>

<div class="form-container">
    <h1>Creazione Nuova Ricevuta</h1>
    <div class="form-group">
        @if(isset($client) && !empty($client))
        <div class="riga"><strong>Seleziona un cliente</strong></div>
        <form action="{{ route('get.ticket.selected.client') }}" method="GET">
        
            <select name="clientid" class="form-select">
                @foreach ($client as $item)
                    <option value="{{ $item['id']}}">{{ $item['name'] }}</option>
                @endforeach
            </select>
    </div>
    <div class="button-container">
        <button type='submit' class="submit-btn" >Conferma</button>
    </div>
        </form>
    
   @endif
    @if(isset($tickets) && !empty($tickets))
    <div class="form-group">
    <div class="riga"><strong>Cliente: </strong>{{$tickets[0]['clientName']}} </div>
    <div class="riga">Selezionare i ticket da includere nella ricevuta. Per i ticket non selezionabili la ricevuta è già stata emessa.</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Seleziona</th>
                    <th>Nome ticket</th>
                    <th>Durata</th>
                    <th>Ricevuta emessa</th>
                </tr>
            </thead>
            <tbody>
                <form action="{{ route('make.pdf') }}" method="GET">
                @csrf
                @foreach ($tickets as $item )
                @if($item['color'] == '#FF0000')
                <tr>
                        <td><input type="checkbox" name="selected_tickets[]" value="{{ $item['id'] }},{{ $item['name'] }},{{ $item['duration'] }}" {{ $item['note'] == 'RICEVUTA_EMESSA' ? 'checked disabled' : '' }}></td>
                        <td>{{$item['name'] }}</td>
                        <td>{{$item['duration']}}</td>
                        @if($item['note'] == '')
                        <td>No</td>
                        @elseif($item['note'] == 'RICEVUTA_EMESSA')
                        <td>Si</td>
                        @endif                               
                    </tr>
                    @endif
                @endforeach

            </tbody>
        </table>
        <input type="hidden" name="idclient" value="{{ $idclient }}">
        <input type="hidden" name="clientname" value="{{$tickets[0]['clientName']}}">

        <div class="button-container">
            <button type='submit' class="submit-btn">Visualizza anteprima</button>
            <form action="{{ route('create.receipt') }}" method="GET">
                @csrf
                <button type="submit" class="cancel-btn">Torna indietro</button>
            </form>
        </div>
        </form>
     
        
    

</div>
@endif
    
</div>
</div>
</body>
</html>