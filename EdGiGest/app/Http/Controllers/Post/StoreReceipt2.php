<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

use App\Models\Receipt;
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
        $client = json_decode($request->input('client'), true);
        $tickets = json_decode($request->input('tickets'), true);

        foreach($tickets as $item)
        {
            $ticket=Ticket::find($item['id']);
            $ticket->Rendicontato=1;  
            $ticket->save();
        }

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
        $clientMail = $clientData->Email;

        // Array per salvare le ricevute create
        $savedReceipts = [];

        //recupero il sistemista associato
        $users = [];

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

            $cfuser = $receipt['CF_Sistemista'];
            $user = User::where('CF', $cfuser)->firstOrFail();
            $users[] = $user;


            // Salva la ricevuta nel database
            $receipt->save();

            // Aggiungo la ricevuta salvata all'array
            $savedReceipts[] = $receipt;
        }

        // Percorsi dei file PDF da allegare
        $pathpdf = array_map(fn($r) => storage_path($r->Percorso_File), $savedReceipts);

        // Invio la mail con i due PDF allegati
        Mail::to($clientMail)
            ->bcc("info@edgitech.it") // Aggiunge info@edgitech.it in CCN
            ->send(new SendReceiptMail2($pathpdf,$users));

        $sendmail = 'yes';

        return view('ReceiptSaved', [
            'sendmail' => $sendmail,
            'savedReceipts' => $savedReceipts,
        ]);


    }
}
