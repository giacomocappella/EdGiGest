<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserimento Nuovo Cliente</title>
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
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            margin: 0 auto;
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

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            text-transform: uppercase;
        }

        .submit-btn:hover {
            background-color: #45a049;
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

<div class="form-container">
    <h1>Inserimento Nuovo Cliente</h1>
    <form method="post" action="{{ route('store.client') }}">
        @csrf
        <div class="form-group">
            <label for="Ragione_Sociale">Ragione Sociale</label>
            <input type="text" name="Ragione_Sociale" value="{{ old('Ragione_Sociale') }}">
            @error('Ragione_Sociale')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Partita_IVA_CF">Partita IVA / Codice Fiscale</label>
            <input type="text" name="Partita_IVA_CF" value="{{ old('Partita_IVA_CF') }}">
            @error('Partita_IVA_CF')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Mail_amministrazione">Indirizzo Email Amministrazione</label>
            <input type="email" name="Mail_amministrazione" value="{{ old('Mail_amministrazione') }}">
            @error('Mail_amministrazione')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Mail_ticket">Indirizzo Email per Invio Ticket</label>
            <input type="email" name="Mail_ticket" value="{{ old('Mail_ticket') }}">
            @error('Mail_ticket')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Contatto_telefonico">Contatto Telefonico</label>
            <input type="tel" name="Contatto_telefonico" value="{{ old('Contatto_telefonico') }}">
            @error('Contatto_telefonico')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Via">Via</label>
            <input type="text" name="Via" value="{{ old('Via') }}">
            @error('Via')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Civico">Civico</label>
            <input type="text" name="Civico" value="{{ old('Civico') }}">
            @error('Civico')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Citta">Città</label>
            <input type="text" name="Citta" value="{{ old('Citta') }}">
            @error('Citta')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Cap">CAP</label>
            <input type="text" name="Cap" value="{{ old('Cap') }}">
            @error('Cap')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Provincia">Provincia</label>
            <input type="text" name="Provincia" value="{{ old('Provincia') }}">
            @error('Provincia')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="submit-btn">Crea Nuovo Cliente</button>
    </form>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>

</body>
</html>
