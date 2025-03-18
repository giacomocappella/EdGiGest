<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dettagli Profilo Utente</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css"> 
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
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            margin: auto;
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

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

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

        .submit-btn:hover {
            background-color: #007f8a;
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
                    <h3>Crea Ricevuta</h3>
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
        <h1>Dettagli Profilo Utente</h1>
        <form method="POST" action="{{ route('store.edit.profile') }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" value="{{ $user->name }}" required readonly>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required readonly>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="******">
            </div>

            <div class="form-group">
                <label>Codice Fiscale</label>
                <input type="text" name="CF" value="{{ $user->CF }}" required readonly>
            </div>

            <div class="form-group">
                <label>Via</label>
                <input type="text" name="Via" value="{{ $user->Via }}">
            </div>

            <div class="form-group">
                <label>Civico</label>
                <input type="text" name="Civico" value="{{ $user->Civico }}">
            </div>

            <div class="form-group">
                <label>Città</label>
                <input type="text" name="Citta" value="{{ $user->Citta }}">
            </div>

            <div class="form-group">
                <label>CAP</label>
                <input type="text" name="CAP" value="{{ $user->CAP }}">
            </div>

            <div class="form-group">
                <label>Provincia</label>
                <input type="text" name="Provincia" value="{{ $user->Provincia }}">
            </div>

            <div class="form-group">
                <label>IBAN</label>
                <input type="text" name="iban" value="{{ $user->iban }}">
            </div>

            <div class="button-container">
                <button type="submit" class="submit-btn">Salva Modifiche</button>
            </div>
        </form>
    </div>
    </div>
</body>
</html>
