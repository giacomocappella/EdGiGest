<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

use App\Models\Receipt;
use App\Models\Client;
use App\Mail\SendReceiptMail;

class StoreReceipt extends Controller
{
    //l'invoke gestisce la creazione senza invio mail
    public function __invoke(Request $request)
    {
        //recupero i ticket per modificare il campo note in "ricevuta ok"
        $tickets=json_decode($request->input('tickets'), true);

        //chiamate API per modificare il campo
        $apiKey = env('API_KEY'); 
        foreach($tickets as $ticket){
            $idticket=$ticket['id'];
            $urlticket="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects/$idticket";
        
            $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            ])->withoutVerifying()->put($urlticket, [
            'note' => "RICEVUTA_EMESSA",
            ]);
            //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)
            if (!$response->successful())                             
                return response()->json(['error' => 'Unable to fetch data'], 500);
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

        return view ('ReceiptSaved');
    }
    //gestisce lo store con invio mail
    public function StoreSendMail(Request $request)
    {
        //recupero i ticket per modificare il campo note in "ricevuta ok"
        $tickets=json_decode($request->input('tickets'), true);

        //chiamate API per modificare il campo
        $apiKey = env('API_KEY'); 
        foreach($tickets as $ticket){
            $idticket=$ticket['id'];
            $urlticket="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/projects/$idticket";
        
            $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            ])->withoutVerifying()->put($urlticket, [
            'note' => "RICEVUTA_EMESSA",
            ]);
            //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)
            if (!$response->successful())                             
                return response()->json(['error' => 'Unable to fetch data'], 500);
        }

        $nameclient = $request->input('clientname');

        //recupero mail del cliente
        $client=Client::where('Ragione_Sociale',$nameclient)->first();
        if($client)
            $clientmail=$client->Mail_amministrazione;
        else
            echo "Cliente non trovato.";

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
        dd($receipt);
        // Salva la ricevuta nel database
        $receipt->save();

        Mail::to($clientmail, "support@caregnatoedoardo.it")->send(new SendReceiptMail(storage_path($receipt->Percorso_File)));

        return view ('ReceiptSaved');
    }
}
