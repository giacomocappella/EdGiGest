<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elenco Tickets</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { 
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 { text-align: center; color: #333; font-size: 24px; margin-bottom: 20px; }
        h2 { margin-top: 20px; }

        .form-container {
            width: 70%;
            max-width: 1000px;
            background-color: #fff;
            padding: 20px;
            margin: auto auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label { font-weight: bold; display: block; margin-bottom: 10px; }
        select {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { text-align: left; padding: 10px; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .radio-btn { text-align: center; }

        .button-container { display: flex; justify-content: flex-end; margin-bottom: 20px; }
        .submit-btn {
            background-color: #006972;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
        }
        .submit-btn:hover { background-color: #007f8a; }

        /* Logo */
        .logo {
    display: flex;
    align-items: center; /* centra verticalmente l’immagine e il testo */
    gap: 10px;
}

.logo img {
    width: 50px;
    height: 50px;
}

.logo h2 {
    margin: 0;
    line-height: 50px; /* stessa altezza dell’immagine per centraggio perfetto */
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="logo.png" alt="Logo">
                    <h2>EdGi<span class="danger">Gest</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="/"><span class="material-icons-sharp">dashboard</span><h3>Dashboard</h3></a>
                <a href="/newclient"><span class="material-icons-sharp">person_add</span><h3>Nuovo Cliente</h3></a>
                <a href="/client"><span class="material-icons-sharp">group</span><h3>Lista Clienti</h3></a>
                <a href="/newticket"><span class="material-icons-sharp">add</span><h3>Nuovo Ticket</h3></a>
                <a href="/newservice"><span class="material-icons-sharp">add_to_queue</span><h3>Nuovo Servizio</h3></a>
                <a href="/ticket"><span class="material-icons-sharp">format_list_numbered</span><h3>Lista Tickets</h3></a>
                <a href="/newreceipt"><span class="material-icons-sharp">euro_symbol</span><h3>Crea Ricevuta</h3></a>
                <a href="/settings"><span class="material-icons-sharp">settings</span><h3>Impostazioni</h3></a>
                <a href="/profile" class="button-link sidebar-footer"><span class="material-icons-sharp">account_circle</span><h3>{{ Auth::user()->name }}</h3></a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">@csrf</form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="button-link"><span class="material-icons-sharp">logout</span><h3>Logout</h3></a>
            </div>
        </aside>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <div class="form-container">
            <h1>Elenco Tickets</h1>

            <!-- Listbox clienti -->
            <label for="client-select">Seleziona Cliente:</label>
            <select id="client-select">
                <option value="" selected disabled>Seleziona Cliente</option>
                @foreach($tickets->groupBy('Ragione_Sociale') as $cliente => $ticketGroup)
                    <option value="{{ Str::slug($cliente) }}">{{ $cliente }}</option>
                @endforeach
            </select>

            <form action="{{ route('get.tasks') }}" method="GET">
                @csrf

                @foreach($tickets->groupBy('Ragione_Sociale') as $cliente => $ticketGroup)
                    <div class="client-table" data-cliente="{{ Str::slug($cliente) }}" style="display:none;">
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Seleziona</th>
                                    <th>#</th>
                                    <th>Nome Ticket</th>
                                    <th>Stato</th>
                                    <th>Data Ultimo Aggiornamento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ticketGroup->sortByDesc('updated_at') as $ticket)
                                <tr>
                                    <td class="radio-btn"><input type="radio" name="idticket" value="{{ $ticket->id }}"></td>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->Nome }}</td>
                                    <td>{{ $ticket->Stato }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ticket->updated_at)->format('d.m.Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

                <div class="button-container">
                    <button type="submit" class="submit-btn">Vedi dettagli</button>
                </div>
            </form>
        </div>
        <!-- End Main Content -->

    </div>

    <script>
        const select = document.getElementById('client-select');
        const clientTables = document.querySelectorAll('.client-table');

        select.addEventListener('change', () => {
            const value = select.value;

            clientTables.forEach(table => {
                table.style.display = (table.dataset.cliente === value) ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>
