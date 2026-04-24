<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Fattura</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css"> <!-- Assicurati che questo link punti al tuo file CSS -->
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
            width: 70%;
            max-width: 1000px;
            background-color: #fff;
            padding: 20px;
            margin: auto auto;
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
            background-color: #006972;
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
            background-color: #007f8a;
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

        .riga {
            margin-bottom: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="/logo.png">
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
                    <h3>Crea Fattura</h3>
                </a>
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

<div class="form-container">
    <h1>Creazione Fattura</h1>
    <div class="form-group">
        @if(isset($client) && !empty($client))
        <div class="riga"><strong>Seleziona un cliente</strong></div>
        <form action="{{ route('get.ticket.selected.client') }}" method="GET">
        
            <select name="clientid" class="form-select">
                @foreach ($client as $item)
                    <option value="{{ $item->Partita_IVA_CF}}">{{ $item->Ragione_Sociale }}</option>
                @endforeach
            </select>
    </div>
    <div class="button-container">
        <button type='submit' class="submit-btn" >Conferma</button>
    </div>
        </form>
    
   @endif
    @if(isset($tickets) && !empty($tickets))
    <div class="form-group">
        <div class="riga"><strong>Cliente: </strong>{{$clientname}}</div>
        <div class="riga">Selezionare i ticket da includere nella fattura. Per i ticket non selezionabili la fattura è già stata emessa.</div>
    
        <form action="{{ route('make.pdf') }}" method="GET">
            @csrf
    
            <table class="table">
                <thead>
                    <tr>
                        <th>Seleziona</th>
                        <th>#</th>
                        <th>Nome ticket</th>
                        <th>Durata</th>
                        <th>Tecnici</th>
                        <th>Fattura emessa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $item)
                        @if($item->Stato == "Chiuso")
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected_tickets[]" value="{{ $item->id }}" data-hours="{{ $item->Ore_totali }}"
                                        {{ $item->Rendicontato == 1 ? 'checked disabled' : '' }}>
                                </td>
                                <td>{{$item->id }}</td>
                                <td>{{$item->Nome }}</td>
                                <td>{{ number_format($item->Ore_totali, 2, ',', '') }} h</td>
                                <td>@if($item->Doppio_tecnico==1) 2 @else 1 @endif</td>
                                <td>{{ $item->Rendicontato == 1 ? 'Si' : 'No' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
    
            <input type="hidden" name="idclient" value="{{ $idclient }}">
            <input type="hidden" name="clientname" value="{{$clientname}}">
    
            <!-- Selezione Tecnico -->
            <div class="form-group" style="display: flex; flex-direction: column; gap: 12px;">

                <!-- Riga 1 -->
                <div style="display: flex; align-items: center; gap: 20px;">
                    <label style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" id="enable_technician" name="enable_technician"
                            onchange="toggleTechnicianSelect()">
                        Fattura singola
                    </label>

                    <select name="technician_id" id="technician_select" disabled style="width: 200px;">
                        <option value="">-- Seleziona Tecnico --</option>
                        @foreach($users as $technician)
                            <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Riga 2 -->
                <div id="percentage_div"
                    style="display: flex; align-items: center; gap: 40px; max-width: 900px;">

                    <!-- Giacomo -->
                    <div style="text-align: center;">
                        <label>Giacomo: <span id="giacomo_percent">50</span>%</label>
                        <input type="hidden" name="giacomo_percent" id="giacomo_percent_input">
                        <input type="text" name="giacomo_amount" id="giacomo_amount"
                            value="50" readonly style="width: 100px; text-align: center;">
                    </div>

                    <!-- Slider -->
                    <div style="flex-grow: 1; display: flex; flex-direction: column; align-items: center;">
                        <input type="range" id="percent_slider" min="0" max="100" value="50"
                            style="width: 100%;">
                    </div>

                    <!-- Edoardo -->
                    <div style="text-align: center;">
                        <label>Edoardo: <span id="edoardo_percent">50</span>%</label>
                        <input type="hidden" name="edoardo_percent" id="edoardo_percent_input">
                        <input type="text" name="edoardo_amount" id="edoardo_amount"
                            value="50" readonly style="width: 100px; text-align: center;">
                    </div>

                    <!-- Totale -->
                    <div style="text-align: center;">
                        <label>Importo netto:</label>
                        <input type="text" name="net_total" id="net_total"
                            value="0" readonly style="width: 100px; text-align: center;">
                    </div>

                </div>
            </div>
    
           <script>
                const slider = document.getElementById('percent_slider');

                const giacomoPercent = document.getElementById('giacomo_percent');
                const edoardoPercent = document.getElementById('edoardo_percent');

                const giacomoAmount = document.getElementById('giacomo_amount');
                const edoardoAmount = document.getElementById('edoardo_amount');

                const netTotal = document.getElementById('net_total');

                // Tutti i checkbox dei ticket
                const ticketCheckboxes = document.querySelectorAll('input[name="selected_tickets[]"]');

                // 🔹 Calcolo totale ore selezionate
                function calculateTotalHours() {
                    let totalHours = 0;

                    ticketCheckboxes.forEach(cb => {
                        // ESCLUDI quelli già rendicontati (disabled)
                        if (cb.checked && !cb.disabled) {
                            totalHours += parseFloat(cb.dataset.hours);
                        }
                    });

                    return totalHours;
                }
                function toggleTechnicianSelect() {
                    const checkbox = document.getElementById('enable_technician');
                    const select = document.getElementById('technician_select');
                    const percentageDiv = document.getElementById('percentage_div');

                    if (checkbox.checked) {
                        // Fattura singola
                        select.disabled = false;
                        percentageDiv.style.display = 'none';
                    } else {
                        // Multipla
                        select.disabled = true;
                        select.value = "";
                        percentageDiv.style.display = 'flex';
                    }
                }
                // 🔹 Aggiorna TUTTO (totale + divisione tecnici)
                function updateAll() {
                    let totalHours = calculateTotalHours();
                    let costoOrario = {{ $hourprice }};

                    // Totale netto (ore * costo orario netto)
                    let totalNet = totalHours * costoOrario;

                    // Percentuali
                    let percGiacomo = parseInt(slider.value);
                    let percEdoardo = 100 - percGiacomo;

                    // Importi per tecnico
                    let giacomoNet = (totalNet * percGiacomo / 100);
                    let edoardoNet = (totalNet * percEdoardo / 100);

                    // Aggiornamento UI
                    giacomoPercent.textContent = percGiacomo;
                    edoardoPercent.textContent = percEdoardo;

                    giacomoAmount.value = giacomoNet.toFixed(2);
                    edoardoAmount.value = edoardoNet.toFixed(2);

                    document.getElementById('giacomo_percent_input').value = percGiacomo;
                    document.getElementById('edoardo_percent_input').value = percEdoardo;

                    netTotal.value = totalNet.toFixed(2);
                }

                // 🔹 Eventi checkbox (quando spunti/despunti)
                ticketCheckboxes.forEach(cb => {
                    cb.addEventListener('change', updateAll);
                });

                // 🔹 Evento slider
                slider.addEventListener('input', updateAll);

                // 🔹 Init
                document.addEventListener('DOMContentLoaded', function() {
                    updateAll();
                });
                </script>
    
            <div class="button-container" style="display: flex; gap: 15px; align-items: center;">
                <button type='submit' class="submit-btn">Visualizza anteprima</button>
            </form>
    
            <form action="{{ route('create.receipt') }}" method="GET">
                @csrf
                <button type="submit" class="cancel-btn">Torna indietro</button>
            </form>
        </div>
    </div>
    
@endif
    
</div>
</div>
</body>
</html>