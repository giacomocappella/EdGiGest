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

use App\Mail\SendReceiptMail;

class StoreReceipt extends Controller
{
    //l'invoke gestisce la creazione senza invio mail
    public function __invoke(Request $request)
    {
        //recupero i ticket per modificare il campo note in "ricevuta ok"
        $ticketsrec=json_decode($request->input('tickets'), true);
 
        foreach($ticketsrec as $item)
        {
            $ticket=Ticket::find($item['id']);
            $ticket->Rendicontato=1;  
            $ticket->save();
        }

        //creo oggetto ricevuta e poi lo salvo con tutti i dati provenienti dalla view
        $receipt = new Receipt();
        $receipt->Numero = $request->input('numero');
        $receipt->Anno = $request->input('anno');
        $receipt->Data = $request->input('data');
        $receipt->P_IVA_CF_Cliente = $request->input('p_iva_cf_cliente');
        $receipt->CF_Sistemista = $request->input('cf_sistemista');
        $receipt->Importo_Netto = $request->input('importo_netto');
        $receipt->Importo_Lordo = $request->input('importo_lordo');
        $receipt->Percorso_File = $request->input('percorso_file');

        // Salva la ricevuta nel database
        $receipt->save();

        $sendmail='no';

        return view ('ReceiptSaved',['sendmail'=> $sendmail]);
    }
    //gestisce lo store con invio mail
    public function StoreSendMail(Request $request)
    {
        //recupero i ticket per modificare il campo note in "ricevuta ok"
        $ticketsrec=json_decode($request->input('tickets'), true);

        foreach($ticketsrec as $item)
        {
            $ticket=Ticket::find($item['id']);
            $ticket->Rendicontato=1;  
            $ticket->save();
        }

        $idclient = $request->input('p_iva_cf_cliente');

        //recupero mail del cliente
        $client=Client::findOrFail($idclient);
        $clientmail=$client->Mail_amministrazione;

        //recupero il sistemista associato
        $cfuser=$request->input('cf_sistemista');

        $user = User::where('CF', $cfuser)->firstOrFail();

        //creo oggetto ricevuta e poi lo salvo con tutti i dati provenienti dalla view
        $receipt = new Receipt();
        $receipt->Numero = $request->input('numero');
        $receipt->Anno = $request->input('anno');
        $receipt->Data = $request->input('data');
        $receipt->P_IVA_CF_Cliente = $request->input('p_iva_cf_cliente');
        $receipt->CF_Sistemista = $request->input('cf_sistemista');
        $receipt->Importo_Netto = $request->input('importo_netto');
        $receipt->Importo_Lordo = $request->input('importo_lordo');
        $receipt->Percorso_File = $request->input('percorso_file');

        // Salva la ricevuta nel database
        $receipt->save();

        Mail::to($clientmail)
                ->bcc("info@edgitech.it") // Aggiunge info@edgitech.it in CCN
                ->send(new SendReceiptMail(storage_path($receipt->Percorso_File), $user));


        $sendmail='yes';

        return view ('ReceiptSaved',['sendmail'=> $sendmail]);

    }
}
