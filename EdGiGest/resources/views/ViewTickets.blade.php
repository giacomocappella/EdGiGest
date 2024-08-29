<head>
    <title>Elenco Tickets</title>
</head>
<body>
    <h1>ELENCO TICKETS</h1>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Nome Ticket</th>
                    <th>Stato</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket['clientName'] }}</td>
                    <td>{{ $ticket['name'] }}</td>
                    <td>@if($ticket['color']=='#8bc34a')
                        Aperto
                    @elseif($ticket['color']=='#ff8000')
                        Sospeso
                    @else
                        Chiuso
                    @endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
