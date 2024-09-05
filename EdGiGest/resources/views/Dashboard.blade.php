<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
    </style>
</head>
<body>
    <h1>EDGIGEST - DASHBOARD</h1>
    <h2>Elenco dei tickets aperti e sospesi per cliente</h2>

    @foreach ($groupedTickets as $clientName => $tickets)
        <div class="client">
            <h2>Cliente: {{ $clientName }}</h2>
            
            @foreach ($tickets as $ticket)
            <form action="{{route('get.tasks')}}" method="GET">
            @csrf
            @if($ticket['color']=='#689F38')
                <div class="ticket">
                    <h3>{{ $ticket['name'] }}</h3>
                    <p class="details">Durata: {{ $ticket['duration'] }}</p>
                    <p class="details">ID Ticket: {{ $ticket['id'] }}</p>
                    <p class="details">Stato: @if($ticket['color']=='#689F38')
                        Aperto
                    @elseif($ticket['color']=='#FF5722')
                        Sospeso
                    @else
                        Chiuso
                    @endif</td></p>
                    <p><input type="hidden" name="id" value="{{ $ticket['id'] }}">
                        <button type="submit">Vedi Dettagli</button></p>
                    </div>
                    
            @endif
            @if($ticket['color']=='#FF5722')
                <div class="ticket_suspended">
                    <h3>{{ $ticket['name'] }}</h3>
                    <p class="details">Durata: {{ $ticket['duration'] }}</p>
                    <p class="details">ID Ticket: {{ $ticket['id'] }}</p>
                    <p class="details">Stato: @if($ticket['color']=='#689F38')
                        Aperto
                    @elseif($ticket['color']=='#FF5722')
                        Sospeso
                    @else
                        Chiuso
                    @endif</td></p>
                    <p><input type="hidden" name="id" value="{{ $ticket['id'] }}">
                        <button type="submit">Vedi Dettagli</button></p>
                    </div>
            @endif
            </form>
            @endforeach
        </div>
    @endforeach
</body>
</html>
