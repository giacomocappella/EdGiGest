<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Tickets</title>
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

        .radio-btn {
            text-align: center;
        }

        .button-container {
            text-align: right;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
        }

        button:hover {
            background-color: #45a049;
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

<div class="table-container">
    <h1>Elenco Tickets</h1>
    <form action="{{ route('get.tasks') }}" method="GET">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>Seleziona</th>
                    <th>Cliente</th>
                    <th>Nome Ticket</th>
                    <th>Stato</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                <tr>
                    <td class="radio-btn"><input type="radio" name="idticket" value="{{ $ticket['id'] }}"></td>
                    <td>{{ $ticket['clientName'] }}</td>
                    <td>{{ $ticket['name'] }}</td>
                    <td>
                        @if($ticket['color'] == '#689F38')
                            Aperto
                        @elseif($ticket['color'] == '#FF5722')
                            Sospeso
                        @else
                            Chiuso
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="button-container">
            <button type="submit" class="submit-btn">Vedi dettagli</button>
            <a href="{{ route('dashboard') }}" class="cancel-btn">Torna alla Dashboard</a>
        </div>
    </form>
</div>

</body>
</html>
