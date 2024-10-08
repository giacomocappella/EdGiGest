<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anteprima Ricevuta</title>
</head>
<body>
    <h1>Anteprima Ricevuta</h1>

    <!-- Mostra il PDF in un iframe -->
    <iframe src="{{ route('preview.pdf', ['filename' => basename($pathpdf)]) }}" width="100%" height="600px"></iframe>

    <!-- Modulo di conferma -->
    <form action="{{ route('store.receipt') }}" method="POST">
        @csrf
        <input type="hidden" name="numero" value="{{ $receipt->Numero }}">
        <input type="hidden" name="anno" value="{{ $receipt->Anno }}">
        <input type="hidden" name="data" value="{{ $receipt->Data }}">
        <input type="hidden" name="p_iva_cf_cliente" value="{{ $client->Partita_IVA_CF }}">
        <input type="hidden" name="cf_sistemista" value="{{ $sys_admin->Codice_Fiscale }}">
        <input type="hidden" name="importo_netto" value="{{ number_format($receipt->Importo_Netto, 2) }}">
        <input type="hidden" name="importo_lordo" value="{{ number_format($receipt->Importo_Lordo, 2) }}">
        <input type="hidden" name="percorso_file" value="{{ $pathpdf }}">
        <input type="hidden" name="taxsum" value="{{ $taxsum }}">
        <input type="hidden" name="dateita" value="{{ $dateita }}">
        
        <p>Cliccando su conferma verrà scaricata una copia della ricevuta definitiva</p>
        <button type="submit">Conferma e scarica una copia</button>
    </form>

    <a href="{{ url()->previous() }}">Annulla</a>
</body>
</html>
