<head>
  <title>Dashboard</title>
</head>
<body>
  <h1>DASHBOARD</h1>
  <div>
    @foreach($tickets as $client)
    {{$client['clientName']}}
    <br>
    @endforeach
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
              @foreach($tickets as $ticket)
              <tr>
                  <td><input type="radio" name="radiotickets" value="{{$ticket['id']}}"></td>
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
