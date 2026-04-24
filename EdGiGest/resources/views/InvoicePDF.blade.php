<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ricevuta</title>
    <style>
        h4 {
            margin: 0;
        }
        .w-full {
            width: 100%;
        }
        .w-half {
            width: 50%;
        }
        .margin-top {
            margin-top: 1.25rem;
        }
        .footer {
            font-size: 0.875rem;
            padding: 1rem;
            background-color: rgb(241 245 249);
        }
        table {
            width: 100%;
            border-spacing: 0;
        }
        th {
            text-align: left;
        }
        table.products {
            font-size: 0.875rem;
        }
        table.products tr {
            background-color: rgb(105 105 105);
        }
        table.products th {
            color: #ffffff;
            padding: 0.5rem;
        }
        table tr.items {
            background-color: rgb(241 245 249);
        }
        table tr.items td {
            padding: 0.5rem;
        }
        .total {
            text-align: right;
            margin-top: 1rem;
            font-size: 1rem;
            line-height: 1.5;
        }
        .signature {
            text-align: right;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <img src='logo.jpg' width="100" />
            </td>
            <td class="w-half">
                <h3>Fattura n. {{$invoice->numero}} del {{$dateita}}</h3>
                <p>Progressivo invio {{ $invoice->progressivo_invio }}</p>
            </td>
        </tr>
    </table>
 
    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div><h4>EdGiTech di {{$sys_admin->name}}</h4></div>
                    <div>{{$sys_admin->Via}} {{$sys_admin->Civico}}</div>
                    <div>{{$sys_admin->CAP}} - {{$sys_admin->Citta}} ({{$sys_admin->Provincia}})</div>
                    <div>Partita IVA {{$sys_admin->Partita_Iva}}</div>

                    

                </td>
                <td class="w-half">
                    <div><h4>Spett.le</h4></div>
                    <div>{{$client->Ragione_Sociale}}</div>
                    <div>{{$client->Via}} {{$client->Civico}}</div>
                    <div>{{$client->Cap}} - {{$client->Citta}} ({{$client->Provincia}})</div>
                    <div>P.IVA {{$client->Partita_IVA_CF}}</div>
                    <div>Codice Fiscale {{$client->Codice_Fiscale}}</div>
                    <div>Codice Destinatario {{$client->Cod_destinatario}}</div>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <h2 style="text-align: center;">FATTURA DI CORTESIA </h2>
    <h3 style="text-align: center;">Consulenza Tecnico Informatica</h3>
    <br>
    <p> Ticket inclusi nella presente fattura:</p>
    <div class="margin-top">
        <table class="products">
            <tr>
                <th>#</th>
                <th>Nome Ticket</th>
            </tr>
            @foreach($tickets as $item)
            <tr class="items">
                    <td>
                        {{ $item->id }}
                    </td>
                    <td>
                        {{ $item->Nome }}
                    </td>
            </tr>
            @endforeach
        </table>
    </div>
    <br><br>
    <div class="total">
        <b>Totale competenze: € {{ number_format($invoice->prezzo_totale, 2, ',', '.') }}</b><br>
        Rivalsa INPS 4%: € {{ number_format( $invoice->importo_totale-$invoice->prezzo_totale , 2, ',', '.') }} <br>
       <hr>
       <b>Totale fattura: € {{ number_format($invoice->importo_totale, 2, ',', '.') }}</b>
    </div>
    <br><br>
    <div class="footer margin-top">
        <div>
            Operazione senza applicazione dell'IVA ai sensi dell'art. 1, co. da 54 a 89, Legge 190/2014, regime forfetario, come modificato dalle Legge 208/2015 e dalla Legge 145/2018.
        </div>
    </div>
    <div class="footer margin-top">
        <div>
            Senza applicazione della ritenuta alla fonte a titolo di acconto ai sensi dell'art. 1, co. 67, Legge 190/2014.
        </div>
    </div>
</body>
</html>
