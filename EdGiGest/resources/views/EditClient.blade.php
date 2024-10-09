<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Cliente</title>
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

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input:focus {
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

        .cancel-btn {
            background-color: #f44336;
        }

        .cancel-btn:hover {
            background-color: #e53935;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="/logo.png">
                    <h2>Edgi<span class="danger">Gest</span></h2>
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
                <a href="/settings">
                    <span class="material-icons-sharp">
                        settings
                    </span>
                    <h3>Impostazioni</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>

<div class="form-container">
    <h1>Modifica anagrafica cliente</h1>
    <form method="post" action="{{ route('store.edit.client') }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="Ragione_Sociale">Ragione Sociale</label>
            <input type="text" name="Ragione_Sociale" value="{{($client['Ragione_Sociale'])}}">
            @error('Ragione_Sociale')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Partita_IVA_CF">Partita IVA / Codice Fiscale</label>
            <input type="text" name="Partita_IVA_CF" value="{{($client['Partita_IVA_CF']) }}">
            @error('Partita_IVA_CF')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Mail_amministrazione">Indirizzo Email Amministrazione</label>
            <input type="email" name="Mail_amministrazione" value="{{($client['Mail_amministrazione']) }}">
            @error('Mail_amministrazione')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Mail_ticket">Indirizzo Email per Invio Ticket</label>
            <input type="email" name="Mail_ticket" value="{{($client['Mail_ticket']) }}">
            @error('Mail_ticket')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Contatto_telefonico">Contatto Telefonico</label>
            <input type="tel" name="Contatto_telefonico" value="{{($client['Contatto_telefonico']) }}">
            @error('Contatto_telefonico')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Via">Via</label>
            <input type="text" name="Via" value="{{($client['Via']) }}">
            @error('Via')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Civico">Civico</label>
            <input type="text" name="Civico" value="{{($client['Civico']) }}">
            @error('Civico')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Citta">Città</label>
            <input type="text" name="Citta" value="{{($client['Citta']) }}">
            @error('Citta')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Cap">CAP</label>
            <input type="text" name="Cap" value="{{($client['Cap']) }}">
            @error('Cap')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Provincia">Provincia</label>
            <input type="text" name="Provincia" value="{{($client['Provincia']) }}">
            @error('Provincia')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="button-container">
            <button type="submit" class="submit-btn">Modifica cliente</button>

        </div>
    </form>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>
</div>
</body>
</html>
