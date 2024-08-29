<div>
    <h1> INSERIMENTO NUOVO CLIENTE </h1>
    <br>
    <form method="post" action="{{ route('store.client') }}">
        @csrf
        <div>
            <label for="Ragione Sociale">Ragione Sociale:</label>
            <input type="text" name="Ragione_Sociale" value="{{ old('Ragione_Sociale') }}">
            @error('Ragione_Sociale')
            <div style="color:red;">{{ $message }}</div>
            @enderror
        </div><br>
        <div>
            <label for="Partita_IVA_CF">Partita IVA / Codice fiscale:</label>
            <input type="text" name="Partita_IVA_CF" value="{{ old('Partita_IVA_CF') }}">
            @error('Partita_IVA_CF')
            <div style="color:red;">{{ $message }}</div>
            @enderror
        </div><br>
        <div>
            <label for="Mail_amministrazione">Indirizzo mail amministrazione:</label>
            <input type="email" name="Mail_amministrazione" value="{{ old('Mail_amministrazione') }}">
            @error('Mail_amministrazione')
            <div style="color:red;">{{ $message }}</div>
            @enderror
        </div><br>
        <div>
            <label for="Mail_ticket">Indirizzo mail per invio ticket:</label>
            <input type="email" name="Mail_ticket" value="{{ old('Mail_ticket') }}">
            @error('Mail_ticket')
            <div style="color:red;">{{ $message }}</div>
            @enderror
        </div><br>
        <div>
            <label for="Contatto_telefonico">Contatto telefonico:</label>
            <input type="tel" name="Contatto_telefonico" value="{{ old('Contatto_telefonico') }}">
            @error('Contatto_telefonico')
            <div style="color:red;">{{ $message }}</div>
            @enderror
        </div><br>
        <div>
            <label for="Via">Via:</label>
            <input type="text" name="Via" value="{{ old('Via') }}">
            @error('Via')
            <div style="color:red;">{{ $message }}</div>
            @enderror
        </div><br>
        <div>
            <label for="Civico">Civico:</label>
            <input type="text" name="Civico" value="{{ old('Civico') }}">
            @error('Civico')
            <div style="color:red;">{{ $message }}</div>
            @enderror
        </div><br>
        <div>
            <label for="Citta">Città:</label>
            <input type="text" name="Citta" value="{{ old('Citta') }}">
            @error('Citta')
            <div style="color:red;">{{ $message }}</div>
            @enderror
        </div><br>
        <div>
            <label for="Cap">Cap:</label>
            <input type="text" name="Cap" value="{{ old('Cap') }}">
            @error('Cap')
            <div style="color:red;">{{ $message }}</div>
            @enderror
        </div><br>
        <div>
            <label for="Provincia">Provincia:</label>
            <input type="text" name="Provincia" value="{{ old('Provincia') }}">
            @error('Provincia')
            <div style="color:red;">{{ $message }}</div>
            @enderror
        </div><br>
        <div>
            <button type="submit">Crea nuovo cliente</button>
        </div>
    </form>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
</div>
