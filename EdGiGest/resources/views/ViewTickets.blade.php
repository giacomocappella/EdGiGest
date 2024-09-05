<head>
    <title>Elenco Tickets</title>
</head>
<body>
    <h1>ELENCO TICKETS</h1>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Cliente</th>
                    <th>Nome Ticket</th>
                    <th>Stato</th>
                </tr>
            </thead>
            <tbody>
                <form action="{{route('get.tasks')}}" method="GET">
                    @csrf
                @foreach($tickets as $ticket)
                <tr>
                    <td><input type="radio" name="id" value="{{$ticket['id']}}" ></td>
                    <td>{{ $ticket['clientName'] }}</td>
                    <td>{{ $ticket['name'] }}</td>
                    <td>@if($ticket['color']=='#689F38')
                        Aperto
                    @elseif($ticket['color']=='#FF5722')
                        Sospeso
                    @else
                        Chiuso
                    @endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <button type="submit">Vedi dettagli</button>
    </div>
</form>
</body>
