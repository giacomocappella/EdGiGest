<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anteprima Ricevuta</title>
</head>
<script>
    function confermaInvio() {
    let scelta = confirm("Vuoi inviare mail al cliente con la copia della ricevuta? Cliccando su annulla non verrà inviata la mail");

    if (scelta) {
        document.getElementById('formSiclose').submit();
    } else {
        document.getElementById('formNoclose').submit();
    }
    }
</script>
<body>
    <h1>Anteprima Ricevuta</h1>

    <!-- Mostra il PDF in un iframe -->
    <iframe src="{{ route('preview.pdf', ['filename' => basename($pathpdf)]) }}" width="80%" height="500px"></iframe>
    <br>
    <button onclick="confermaInvio()">Crea ricevuta</button>
            <form id="formNoclose" action="{{ route('store.receipt') }}" method="POST" style="display: none;">
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
                <input type="hidden" name="tickets" value="{{ json_encode($tickets) }}">
            </form>
            <form id="formSiclose" action="{{ route('store.receipt.mail') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="numero" value="{{ $receipt->Numero }}">
                <input type="hidden" name="anno" value="{{ $receipt->Anno }}">
                <input type="hidden" name="data" value="{{ $receipt->Data }}">
                <input type="hidden" name="p_iva_cf_cliente" value="{{ $client->Partita_IVA_CF }}">
                <input type="hidden" name="clientname" value="{{ $client->Ragione_Sociale}}">
                <input type="hidden" name="cf_sistemista" value="{{ $sys_admin->Codice_Fiscale }}">
                <input type="hidden" name="importo_netto" value="{{ number_format($receipt->Importo_Netto, 2) }}">
                <input type="hidden" name="importo_lordo" value="{{ number_format($receipt->Importo_Lordo, 2) }}">
                <input type="hidden" name="percorso_file" value="{{ $pathpdf }}">
                <input type="hidden" name="taxsum" value="{{ $taxsum }}">
                <input type="hidden" name="dateita" value="{{ $dateita }}">
                <input type="hidden" name="tickets" value="{{ json_encode($tickets) }}">
            </form>
    <a href="{{ url()->previous() }}">Torna indietro</a>
</body>
</html>
