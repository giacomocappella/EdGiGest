<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .client {
            margin-bottom: 20px;
        }
        .client h2 {
            color: #333;
        }
        .ticket {
            padding: 10px;
            background-color: #f9f9f9;
            margin-bottom: 10px;
            border-left: 5px solid #689F38;
        }
        .ticket_suspended {
            padding: 10px;
            background-color: #f9f9f9;
            margin-bottom: 10px;
            border-left: 5px solid #FF5722;
        }
        .ticket h3 {
            margin: 0;
        }
        .ticket .details {
            color: #666;
        }
        .buttons-container {
            margin: 20px 0;
            text-align: center;
        }
        .buttons-container button, .buttons-container a {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
        .buttons-container button:hover, .buttons-container a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>EDGIGEST - DASHBOARD</h1>

    <!-- Bottone di navigazione -->
    <div class="buttons-container">
        <a href="{{ route('create.client') }}" class="button">Inserisci Nuovo Cliente</a>
        <a href="{{ route('create.ticket') }}" class="button">Inserisci Nuovo Ticket</a>
        <a href="{{ route('create.client') }}" class="button">Gestisci ricevute</a>
    </div>

    <h2>Elenco dei tickets aperti e sospesi per cliente</h2>

    @foreach ($groupedTickets as $clientName => $tickets)
        <div class="client">
            <h2>Cliente: {{ $clientName }}</h2>
            
            @foreach ($tickets as $ticket)
                <form action="{{ route('get.tasks') }}" method="GET">
                    @csrf
                    @if($ticket['color'] == '#689F38')
                        <div class="ticket">
                            <h3>{{ $ticket['name'] }}</h3>
                            <p class="details">Durata: {{ $ticket['duration'] }}</p>
                            <p class="details">ID Ticket: {{ $ticket['id'] }}</p>
                            <p class="details">Stato: Aperto</p>
                            <p>
                                <input type="hidden" name="id" value="{{ $ticket['id'] }}">
                                <button type="submit">Vedi Dettagli</button>
                            </p>
                        </div>
                    @endif
                    @if($ticket['color'] == '#FF5722')
                        <div class="ticket_suspended">
                            <h3>{{ $ticket['name'] }}</h3>
                            <p class="details">Durata: {{ $ticket['duration'] }}</p>
                            <p class="details">ID Ticket: {{ $ticket['id'] }}</p>
                            <p class="details">Stato: Sospeso</p>
                            <p>
                                <input type="hidden" name="id" value="{{ $ticket['id'] }}">
                                <button type="submit">Vedi Dettagli</button>
                            </p>
                        </div>
                    @endif
                </form>
            @endforeach
        </div>
    @endforeach
</body>
</html>
