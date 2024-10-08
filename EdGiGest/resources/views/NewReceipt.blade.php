<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea ricevuta</title>
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
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            margin: 0 auto;
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
            background-color: #4CAF50;
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
            background-color: #45a049;
        }

        .cancel-btn {
            background-color: #f44336;
        }

        .cancel-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>CREAZIONE NUOVA RICEVUTA</h1>
    
     @if(isset($client) && !empty($client))
     Seleziona un cliente
    <form action="{{ route('get.ticket.selected.client') }}" method="GET">
       
        <select name="clientid" class="form-select">
            @foreach ($client as $item)
                <option value="{{ $item['id']}}">{{ $item['name'] }}</option>
            @endforeach
        </select>
        <button type='submit'>Conferma</button>
        <a href='/'>Torna alla dashboard</a>
    </form>
   @endif
    @if(isset($tickets) && !empty($tickets))
    <h3>Cliente: {{$tickets[0]['clientName']}}</h3>
    <div class="ticket-closed">
        <p>Selezionare i ticket da includere nella ricevuta</p>
        <table>
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
                        <td><input type="checkbox" name="selected_tickets[]" value="{{ $item['id'] }},{{ $item['name'] }},{{ $item['duration'] }}"></td>
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
        <button type='submit'>Visualizza anteprima</button>
        <a href="{{ url()->previous() }}">Torna indietro</a>
        </form>
     
        
    
</div>
@endif
    
</div>

</body>
</html>