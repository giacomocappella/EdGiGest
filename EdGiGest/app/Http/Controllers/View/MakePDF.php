<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


use App\Models\Client;
use App\Models\Receipt;
use App\Models\System_admin;

class MakePDF extends Controller
{
        public function convertDurationHour($durata)
        {
            $ore = 0;
            $minuti = 0;
        
            // Utilizza una regex per catturare le ore e i minuti
            preg_match('/(\d+)\s*h/', $durata, $matchOre);
            preg_match('/(\d+)\s*min/', $durata, $matchMinuti);
        
            // Se sono state trovate ore, assegnale alla variabile $ore
            if (!empty($matchOre)) {
                $ore = (int)$matchOre[1];
            }
        
            // Se sono stati trovati minuti, assegnali alla variabile $minuti
            if (!empty($matchMinuti)) {
                $minuti = (int)$matchMinuti[1];
            }
        
            // Converti tutto in ore decimali
            $oreDecimali = $ore + ($minuti / 60);
        
            return $oreDecimali;
        }

        public function __invoke(Request $request){
            $tickets=$request->input('selected_tickets');

            //recupero l'id client per recuperare i dati dal database
            $idclient=$request->input('idclient');

            //recupero il nome del cliente da clickify (serve per la ricerca dei dati dal database)
            $apiKey = env('API_KEY'); 
            $urlclient="https://api.clockify.me/api/v1/workspaces/66b9e18097ddfb5029a6f6a3/clients/$idclient";
    
            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
            ])->withoutVerifying()->get($urlclient);
            //RICORDARSI DI VERIFICARE IL CERTIFICATO (PER ORA BYPASSATO)

            if ($response->successful()) {
                $clientcl = $response->json();
                $clientname=$clientcl['name'];

                } 
            else {
                return response()->json([
                    'error' => 'Request failed',
                    'status' => $response->status(),
                    'message' => $response->body(),
                    ], $response->status());
            }
            //divido i dettagli dei ticket che arrivano dalla view
            foreach ($tickets as $ticketData) {
                $ticketArray = explode(',', $ticketData);
            
                $ticketsArray[]= [
                    'id' => $ticketArray[0],
                    'name' => $ticketArray[1],
                    'duration' => $ticketArray[2],
                ];
            }

            //definisco l'importo orario
            $hourlyamount=30.00;

            //definisco la ritenuta d'acconto
            $withholding_tax=0.2;

            //ottengo l'anno corrente
            //creare scelta dell'anno su vista, eventualmente
            $anno=date('Y');

            //ottengo la data odierna che sarà la data della ricevuta
            $currentdate = Carbon::now()->format('Y/m/d');

            //creazione nuova istanza ricevuta su database 
            //recupero l'ultima ricevuta nell'anno correte
            $lastreceipt = Receipt::where('Anno', $anno)
                                   ->orderBy('Numero', 'desc')
                                   ->first();
            
            // Calcola il prossimo numero ricevuta
            if ($lastreceipt) {
                $number = $lastreceipt->Numero + 1;
            } else {
                $number = 1; // Se non esistono ricevute per l'anno corrente, si parte da 1
            }

            //trovo il cliente nel db attraverso il nome ottenuto da clockify dalla view
            $client=Client::where('Ragione_Sociale',$clientname)->first();

            //trovo il sistemista nel db (attraverso l'id utente in futuro)
            $sys_admin=System_admin::where('Codice_Fiscale', 'CPPGCM95A17C111Q')->first();

            //converto le durate e creo una variabile che contiene la somma delle stesse
            $durationhours=0;

            foreach($ticketsArray as $ticket){
                $durationhours+=$this->convertDurationHour($ticket["duration"]);
            }

            $receipt = new Receipt();
            $receipt->Numero = $number;
            $receipt->Anno = $anno;
            $receipt->Data = $currentdate;
            $receipt->P_IVA_CF_Cliente = $client->Partita_IVA_CF;
            $receipt->CF_Sistemista = 'CPPGCM95A17C111Q';  //per ora assegnato così
            $receipt->Importo_Netto = number_format($durationhours*$hourlyamount,2);  //numero ore per importo orario
            $receipt->Importo_Lordo = number_format($receipt->Importo_Netto/(1-$withholding_tax),2);  //conversione netto-lordo con la ritenuta al 20%
            $taxsum=number_format($receipt->Importo_Lordo-$receipt->Importo_Netto,2);

            //converto nuovamente la data per la ricevuta
            $dateita = Carbon::createFromFormat('Y/m/d', $receipt->Data)->format('d/m/Y');
            
            
            //crea il pdf con i dati inseriti
            $pdf = Pdf::loadView('ReceiptPDF', ['tickets'=>$ticketsArray, 'client'=>$client, 'sys_admin'=>$sys_admin, 'receipt'=>$receipt, 'taxsum'=>$taxsum, 'dateita'=>$dateita]);

            // Nome del file
            $filename = 'ricevuta_' .  $receipt->Numero . '_' . $receipt->Anno . '.pdf';

            // Ottieni il contenuto del PDF come stringa
            $pdfcontent = $pdf->output();

            // Salva il PDF nella directory privata "storage/app/private"
            Storage::put('private/' . $filename, $pdfcontent);

            $pathpdf = ('storege/app/private/' . $filename);
            $receipt->Percorso_File = $pathpdf;
            $receipt->save();

            return $pdf->download($filename);


        }
    

}
