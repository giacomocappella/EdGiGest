<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

use App\Models\Receipt;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Ticket;
use App\Models\User;
 
use App\Mail\SendReceiptMail2;

class StoreReceipt2 extends Controller
{
    //l'invoke gestisce la creazione senza invio mail
    public function __invoke(Request $request)
    {
        //recupero tutto dalla vista
        $receipts = json_decode($request->input('receipts'), true);
        $invoices = json_decode($request->input('invoices'), true);
        $client = json_decode($request->input('client'), true);
        $tickets = json_decode($request->input('tickets'), true);

        foreach($tickets as $item)
        {
            $ticket=Ticket::find($item['id']);
            $ticket->Rendicontato=1;  
            $ticket->save();
        }
        
        //salvo le ricevute
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
    
            // Salva la ricevuta nel database
            $receipt->save();
        }

        //salvo le fatture
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
    
            // Salva la fattura nel database
            $invoice->save();
        }
    
        $sendmail = 'no';
    
        return view('ReceiptSaved', [
            'sendmail' => $sendmail,
        ]);
        
    }
    //gestisce lo store con invio mail
    public function StoreSendMail(Request $request)
    {
        // Recupero tutto dalla vista
        $receipts = json_decode($request->input('receipts'), true);
        $invoices = json_decode($request->input('invoices'), true);
        $client = json_decode($request->input('client'), true);
        $tickets = json_decode($request->input('tickets'), true);

        // Segno i ticket come rendicontati
        foreach ($tickets as $item) {
            $ticket = Ticket::find($item['id']);
            $ticket->Rendicontato = 1;
            $ticket->save();
        }

        // Recupero mail del cliente
        $idclient = $client['Partita_IVA_CF'];
        $clientData = Client::findOrFail($idclient);
        $clientMail = $clientData->Mail_amministrazione;

        //array per sistemisti
        $users = [];

        //array per percorsi pdf
        $savedPaths = [];

        foreach ($receipts as $receiptData) {
            // Creo oggetto ricevuta e lo salvo
            $receipt = new Receipt();
            $receipt->Numero = $receiptData['Numero'];
            $receipt->Anno = $receiptData['Anno'];
            $receipt->Data = $receiptData['Data'];
            $receipt->P_IVA_CF_Cliente = $receiptData['P_IVA_CF_Cliente'];
            $receipt->CF_Sistemista = $receiptData['CF_Sistemista'];
            $receipt->Importo_Netto = $receiptData['Importo_Netto'];
            $receipt->Importo_Lordo = $receiptData['Importo_Lordo'];
            $receipt->Percorso_File = $receiptData['Percorso_File'];

            //commento tutto perchè non devo inviare mail per ricevuta occasionale
            /*$cfuser = $receipt['CF_Sistemista'];
            $user = User::where('CF', $cfuser)->firstOrFail();
            $users[] = $user;

            $savedPaths[]= $receipt->Percorso_File;*/

            // Salva la ricevuta nel database
            $receipt->save();

        }

        //salvo le fatture
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

            $user = User::where('id', $invoice->sistemista_id)->firstOrFail();
            $users[] = $user;

            $savedPaths[]= $invoice->percorso_pdf;
    
            // Salva la fattura nel database
            $invoice->save();
        }

        // Percorsi dei file PDF da allegare
        $pathpdf = array_map(fn($r) => storage_path($r), $savedPaths);

        // Invio la mail con i due PDF allegati
        Mail::to($clientMail)
            ->bcc("amministrazione@edgitech.it") // Aggiunge amministrazione@edgitech.it in CCN
            ->send(new SendReceiptMail2($pathpdf,$users));

        $sendmail = 'yes';

        return view('ReceiptSaved', [
            'sendmail' => $sendmail,
        ]);


    }
}
