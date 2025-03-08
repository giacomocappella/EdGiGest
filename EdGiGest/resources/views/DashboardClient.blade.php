<!DOCTYPE html>
<html>
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css\style.css">
    <title>EdGiGest - Dashboard</title>
</head>


<body>
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="logo.png">
                    <h2>EdGi<span class="danger">Gest</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">   
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
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            
<!-- Recent Tickets Table -->
<div class="recent-tickets">
    <h1>Ticket associati al cliente: {{$clientname}}</h1><br>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th class="ticket-name-table">Nome ticket</th>
                <th>Durata</th>
                <th>Tecnici impiegati</th>
                <th>Stato</th>
                <th>Dettagli</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedTickets as $ticket)
                <tr>
                    <td>{{$ticket->id}}</td>
                    <td>{{ $ticket->Nome }}</td>
                    <td>{{$ticket->Ore_totali}} h</td>
                    <td>@if($ticket->Doppio_tecnico==1) 2 @else 1 @endif</td>
                    <td>
                        @if($ticket->Stato == 'Aperto')
                            <span class="status-open">Aperto</span>
                        @elseif($ticket->Stato == 'Sospeso')
                            <span class="status-pending">Sospeso</span>
                        @elseif($ticket->Stato == 'Chiuso')
                            <span class="status-close">Chiuso</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('get.tasks.client') }}" method="GET">
                            @csrf
                            <input type="hidden" name="idticket" value="{{ $ticket->id }}">
                            <button class="details-button" type="submit">Vedi Dettagli</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>  
</div>

<!-- End of Recent Tickets Table -->

            

        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
                </div>

