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
    @if(isset($client) && !empty($client)):
    <form action="{{ route('get.ticket.selected.client') }}" method="GET">

        <select id="clientList" name="Client_list" class="form-select">
            @foreach ($client as $item)
                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
            @endforeach
        </select>
        <button type='submit'>Conferma</button>
    </form>
    @endif
    @if(isset($tickets) && !empty($tickets))
    <div class="ticket-closed">
        <table>
            <thead>
                <tr>
                    <th>Nome ticket</th>
                    <th>Durata</th>
                    <th>Ricevuta creata</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $item )
                @if($item['color'] == '#FF0000')
                <tr>
                        <td>{{$item['name'] }}</td>
                        <td>{{$item['duration']}}</td>
                        @if($item['note'] == '')
                        <td>No</td>
                        @else
                        <td>Si</td>
                        @endif                               
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        
        
    
</div>
@endif
    
</div>

</body>
</html>