<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anteprima Fattura</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css"> 
</head>
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
<script>
    function confermaInvio() {
    let scelta = confirm("Vuoi inviare mail al cliente con la copia della fattura? Cliccando su annulla non verrà inviata la mail");

    if (scelta) {
        document.getElementById('formSiclose').submit();
    } else {
        document.getElementById('formNoclose').submit();
    }
    }
</script>
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
    <h1>Anteprima Fattura</h1>
    <iframe src="{{ route('preview.pdf', ['filename' => basename($pathpdf)]) }}#zoom=65" width="100%" height="600px"></iframe>
    
    <div class="button-container">
    <button onclick="confermaInvio()" class="submit-btn">Crea fattura</button>
            <form id="formNoclose" action="{{ route('store.receipt') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="receipt" value="{{ json_encode($receipt ?? null) }}">
                <input type="hidden" name="invoice" value="{{ json_encode($invoice ?? null) }}">
                <input type="hidden" name="client" value="{{ json_encode($client) }}">
                <input type="hidden" name="tickets" value="{{ json_encode($tickets) }}">
            </form>
            <form id="formSiclose" action="{{ route('store.receipt.mail') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="receipt" value="{{ json_encode($receipt ?? null) }}">
                <input type="hidden" name="invoice" value="{{ json_encode($invoice ?? null) }}">
                <input type="hidden" name="client" value="{{ json_encode($client) }}">
                <input type="hidden" name="tickets" value="{{ json_encode($tickets) }}">
            </form>
            <a href="{{ route('download.xml', ['filename' => basename($xmlPath)]) }}"
                class="submit-btn">
                Scarica XML
                </a>
            <button type="button" class="submit-btn" onclick="window.history.back();">Torna indietro</button>

    </div>
        </div>
    </div>
</body>
</html>
