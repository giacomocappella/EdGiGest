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
                <a href="/newservice">
                    <span class="material-icons-sharp">
                        add_to_queue 
                    </span>
                    <h3>Nuovo Servizio</h3>
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
                <!--<a href="/calendars">
                    <span class="material-icons-sharp">
                        calendar_month
                    </span>
                    <h3>Calendario</h3>
                </a>-->
                <a href="/settings">
                    <span class="material-icons-sharp">
                        settings
                    </span>
                    <h3>Impostazioni</h3>
                </a>
                <a href="/profile" class="button-link sidebar-footer"> 
                    <span class="material-icons-sharp"> 
                        account_circle 
                    </span> 
                    <h3>{{ Auth::user()->name }}</h3>
                    
                </a>
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
            <h1>Statistiche</h1>
            <!-- Analyses -->
            <div class="statistics">
                <div class="opened">
                    <div class="status">
                        <div class="info">
                            <h2>Ticket Aperti</h2>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p>{{$openTicket}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="visits">
                    <div class="status">
                        <div class="info">
                            <h2>Ticket Sospesi</h2>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p>{{$pendingTicket}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="searches">
                    <div class="status">
                        <div class="info">
                            <h2>Clienti</h2>
                        </div>
                        <div class="progresss">
                            <svg>
                                <circle cx="38" cy="38" r="36"></circle>
                            </svg>
                            <div class="percentage">
                                <p>{{$totalclient}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Analyses -->

<!-- Recent Tickets Table -->
<div class="recent-tickets">
    <h1>Ticket aperti e sospesi per ogni cliente</h1><br>
    @foreach ($groupedTickets as $clientName => $tickets)
        @if($tickets->whereIn('Stato', ['Aperto', 'Sospeso'])->count() > 0)
        <div class="client">
            <h2>Cliente: {{ $clientName }}</h2>
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
                    @foreach ($tickets as $ticket)
                        @if(in_array($ticket->Stato, ['Aperto', 'Sospeso']))
                        <tr>
                            <td>{{$ticket->id}}</td>
                            <td>{{ $ticket->Nome}}</td>
                            <td>{{ number_format($ticket->Ore_totali, 2,',') }} h</td>
                            <td>@if($ticket->Doppio_tecnico==1) 2 @else 1 @endif</td>
                            <td>
                                @if($ticket->Stato == 'Aperto')
                                    <span class="status-open">Aperto</span>
                                @elseif($ticket->Stato == 'Sospeso')
                                    <span class="status-pending">Sospeso</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('get.tasks') }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="idticket" value="{{ $ticket->id }}">
                                    <button class="details-button" type="submit">Vedi Dettagli</button>
                                </form>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <br><br>
        </div>
        @endif
    @endforeach
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

            </div>
        </div>
    </div>
    <!-- Optional JS Scripts -->
    <script src="js/script.js" defer></script>

    <script>
        // Funzione per aprire/chiudere il menu
        const closeBtn = document.getElementById('close-btn');
        const sidebar = document.getElementById('sidebar');

        closeBtn.addEventListener('click', () => {
            sidebar.classList.toggle('closed');
        });
    </script>
</body>
</html>
