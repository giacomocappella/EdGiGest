<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
 
use App\Models\Invoice;
use App\Models\Receipt;
use App\Models\Client;
use App\Models\Ticket;
use App\Models\User;

use App\Mail\SendReceiptMail;

class StoreReceipt extends Controller
{
    //l'invoke gestisce la creazione senza invio mail
    public function __invoke(Request $request)
    {
        //recupero tutto dalla vista
        $receipts = $request->receipt ? json_decode($request->receipt) : null;
        $invoices = $request->invoice ? json_decode($request->invoice) : null;
        $client = json_decode($request->input('client'), true);
        $tickets = json_decode($request->input('tickets'), true);
 
        foreach($tickets as $item)
        {
            $ticket=Ticket::find($item['id']);
            $ticket->Rendicontato=1;  
            $ticket->save();
        }

        // Salvo ricevute (solo se esistono)
        if (!empty($receipts)) {
            foreach ($receipts as $receiptData) {
                $receipt = new Receipt();
                $receipt->Numero = $receiptData['Numero'];
                $receipt->Anno = $receiptData['Anno'];
                $receipt->Data = $receiptData['Data'];
                $receipt->P_IVA_CF_Cliente = $receiptData['P_IVA_CF_Cliente'];
                $receipt->CF_Sistemista = $receiptData['CF_Sistemista'];
                $receipt->Importo_Netto = $receiptData['Importo_Netto'];
                $receipt->Importo_Lordo = $receiptData['Importo_Lordo'];
                $receipt->Percorso_File = $receiptData['Percorso_File'];

                $receipt->save();
            }
        }

        // Salvo fatture (solo se esistono)
        if (!empty($invoices)) {
            foreach ($invoices as $invoicesData) {
                $invoice = new Invoice();
                $invoice->numero = $invoicesData['numero'];
                $invoice->anno = $invoicesData['anno'];
                $invoice->data_emissione = $invoicesData['data_emissione'];
                $invoice->tipo_documento = $invoicesData['tipo_documento'];
                $invoice->progressivo_invio = $invoicesData['progressivo_invio'];
                $invoice->client_id = $invoicesData['client_id'];
                $invoice->sistemista_id = $invoicesData['sistemista_id'];
                $invoice->prezzo_totale = $invoicesData['prezzo_totale'];
                $invoice->importo_totale = $invoicesData['importo_totale'];
                $invoice->aliquota_iva = $invoicesData['aliquota_iva'];
                $invoice->natura = $invoicesData['natura'];
                $invoice->modalita_pagamento = $invoicesData['modalita_pagamento'];
                $invoice->data_scadenza = $invoicesData['data_scadenza'];
                $invoice->percorso_xml = $invoicesData['percorso_xml'];
                $invoice->percorso_pdf = $invoicesData['percorso_pdf'];
                $invoice->stato = "creata";

                $invoice->save();
            }
        }

        $sendmail='no';

        return view ('ReceiptSaved',['sendmail'=> $sendmail]);
    }
    //gestisce lo store con invio mail
    public function StoreSendMail(Request $request)
    {
        $receipts = $request->receipt ? json_decode($request->receipt, true) : null;
        $invoices = $request->invoice ? json_decode($request->invoice, true) : null;
        $client = json_decode($request->input('client'), true);
        $tickets = json_decode($request->input('tickets'), true);

        $idclient = $client['Partita_IVA_CF'];
        $clientData = Client::findOrFail($idclient);
        $clientMail = $clientData->Mail_amministrazione;

        foreach($tickets as $item)
        {
            $ticket=Ticket::find($item['id']);
            $ticket->Rendicontato=1;  
            $ticket->save();
        }

        // Salvo ricevute (solo se esistono)
        if (!empty($receipts)) {
            foreach ($receipts as $receiptData) {
                $receipt = new Receipt();
                $receipt->Numero = $receiptData['Numero'];
                $receipt->Anno = $receiptData['Anno'];
                $receipt->Data = $receiptData['Data'];
                $receipt->P_IVA_CF_Cliente = $receiptData['P_IVA_CF_Cliente'];
                $receipt->CF_Sistemista = $receiptData['CF_Sistemista'];
                $receipt->Importo_Netto = $receiptData['Importo_Netto'];
                $receipt->Importo_Lordo = $receiptData['Importo_Lordo'];
                $receipt->Percorso_File = $receiptData['Percorso_File'];

                $receipt->save();

                $pathpdf = array_map(fn($r) => storage_path($r), $receipt->Percorso_File);

                $cfuser = $receipt['CF_Sistemista'];
                $user = User::where('CF', $cfuser)->firstOrFail();
            }
        }

        // Salvo fatture (solo se esistono)
        if (!empty($invoices)) {
            foreach ($invoices as $invoicesData) {
                $invoice = new Invoice();
                $invoice->numero = $invoicesData['numero'];
                $invoice->anno = $invoicesData['anno'];
                $invoice->data_emissione = $invoicesData['data_emissione'];
                $invoice->tipo_documento = $invoicesData['tipo_documento'];
                $invoice->progressivo_invio = $invoicesData['progressivo_invio'];
                $invoice->client_id = $invoicesData['client_id'];
                $invoice->sistemista_id = $invoicesData['sistemista_id'];
                $invoice->prezzo_totale = $invoicesData['prezzo_totale'];
                $invoice->importo_totale = $invoicesData['importo_totale'];
                $invoice->aliquota_iva = $invoicesData['aliquota_iva'];
                $invoice->natura = $invoicesData['natura'];
                $invoice->modalita_pagamento = $invoicesData['modalita_pagamento'];
                $invoice->data_scadenza = $invoicesData['data_scadenza'];
                $invoice->percorso_xml = $invoicesData['percorso_xml'];
                $invoice->percorso_pdf = $invoicesData['percorso_pdf'];
                $invoice->stato = "creata";

                $invoice->save();

                $pathpdf = $invoice->percorso_pdf;
                $user = User::where('id', $invoice->sistemista_id)->firstOrFail();
            }
        }

        Mail::to($clientMail)
                ->bcc("amministrazione@edgitech.it") // Aggiunge amministrazione@edgitech.it in CCN
                ->send(new SendReceiptMail(storage_path($pathpdf), $user));


        $sendmail='yes';

        return view ('ReceiptSaved',['sendmail'=> $sendmail]);

    }
}
