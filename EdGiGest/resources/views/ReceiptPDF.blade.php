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
</style>
</head>
<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <img src='logo.jpg' width="200" />
            </td>
            <td class="w-half">
                <h3>Ricevuta n. {{$receipt['Numero']}} del {{$dateita}}</h3>
            </td>
        </tr>
    </table>
 
    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div><h4>Spett.le</h4></div>
                    <div>{{$client->Ragione_Sociale}}</div>
                    <div>{{$client->Via}} {{$client->Civico}}</div>
                    <div>{{$client->Cap}} - {{$client->Citta}} ({{$client->Provincia}})</div>
                    <div>CF - P.IVA {{$client->Partita_IVA_CF}}</div>
                </td>
                <td class="w-half">
                    <div><h4>Prestatore occasionale:</h4></div>
                    <div>{{$sys_admin->name}}</div>
                    <div>{{$sys_admin->Via}} {{$sys_admin->Civico}}</div>
                    <div>{{$sys_admin->CAP}} - {{$sys_admin->Citta}} ({{$sys_admin->Provincia}})</div>
                    <div>CF {{$sys_admin->CF}}</div>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <h2 style="text-align: center;">RICEVUTA DI PRESTAZIONE OCCASIONALE </h2>
    <h3 style="text-align: center;">CONSULENZA TECNICO INFORMATICA</h3>
    <br>
    <p> Ticket inclusi nella presente ricevuta:</p>
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
        <b>Saldo compenso lordo: € {{ number_format($receipt->Importo_Lordo, 2, ',', '.') }}</b><br>
        Ritenuta d’acconto Irpef 20% - Art. 25 D.P.R. 600/1973: - € {{ number_format($taxsum, 2, ',', '.') }} <br>
       <hr>
       <b>Netto a pagare: € {{ number_format($receipt->Importo_Netto, 2, ',', '.') }}</b>
    </div>
    <br><br>
    <div class="footer margin-top">
        <div>Operazione esclusa da IVA ai sensi dell’art. 5 D.P.R. 633/1972.</div>
        <div><ul>
            <li>Il sottoscritto dichiara che, nell’anno solare {{ $receipt->Anno }}, alla data odierna con questa prestazione non ha conseguito redditi derivanti dall’esercizio di attività di lavoro autonomo occasionale eccedenti € 5.000,00;</li>
            <br>
            <li>Il sottoscritto dichiara inoltre di non essere iscritto (applicazione dell’aliquota contributiva del 23,5%) a forme di previdenza obbligatorie, quali lavoratore subordinato – lavoratore in gestione separata.
            </ul>
        </div>
    </div>
    <div class="footer margin-top">
        <div>Marca da bollo € 2,00 sull'originale.</div>
    </div>
</body>
</html>
