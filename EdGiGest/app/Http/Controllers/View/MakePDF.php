<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Models\Ticket;
use App\Models\Client;
use App\Models\Receipt;
use App\Models\User;

class MakePDF extends Controller
{
        public function __invoke(Request $request){
            //recupero la scelta di ricevuta singola o doppia
            $singolaric = $request->has('enable_technician'); 
            if($singolaric==true)
            {
                $techid = $request->input('technician_id'); // ID del tecnico selezionato 

                $idtickets=$request->input('selected_tickets');

                //se non viene selezionato alcun ticket, torna alla scelta dei clienti
                if($idtickets==null){
                    return redirect()->route('create.receipt');
                }

                //recupero l'id client per recuperare i dati dal database
                $idclient=$request->input('idclient');
               
                //recupero i tickets
                $tickets=Ticket::findOrFail($idtickets);

                //definisco l'importo orario
                $hourlyamount=30.00;

                //definisco la ritenuta d'acconto
                $withholding_tax=0.2;

                //ottengo l'anno corrente
                $anno=date('Y');

                //ottengo la data odierna che sarà la data della ricevuta
                $currentdate = Carbon::now()->format('Y/m/d');

                //creazione nuova istanza ricevuta su database 
                //recupero l'ultima ricevuta nell'anno correte
                $lastreceipt = Receipt::where('Anno', $anno)
                      ->where('id', $techid) // Filtra per tecnico
                      ->orderBy('Numero', 'desc')
                      ->first();
                
                // Calcola il prossimo numero ricevuta
                if ($lastreceipt) {
                    $number = $lastreceipt->Numero + 1;
                } else {
                    $number = 1; // Se non esistono ricevute per l'anno corrente, si parte da 1
                }

                //trovo il cliente nel db
                $client=Client::where($idclient);

                //trovo il sistemista nel db (attraverso l'id utente in futuro)
                $sys_admin=User::where($techid);

                $receipt = new Receipt();
                $receipt->Numero = $number;
                $receipt->Anno = $anno;
                $receipt->Data = $currentdate;
                $receipt->P_IVA_CF_Cliente = $client->Partita_IVA_CF;
                $receipt->CF_Sistemista = $sys_admin->CF;
                $receipt->Importo_Netto = number_format($durationhours*$hourlyamount,2);  //numero ore per importo orario
                $receipt->Importo_Lordo = number_format($receipt->Importo_Netto/(1-$withholding_tax),2);  //conversione netto-lordo con la ritenuta al 20%
                $taxsum=number_format($receipt->Importo_Lordo-$receipt->Importo_Netto,2);

                //converto nuovamente la data per la ricevuta
                $dateita = Carbon::createFromFormat('Y/m/d', $receipt->Data)->format('d/m/Y');
                
                
                //crea il pdf con i dati inseriti
                $pdf = Pdf::loadView('ReceiptPDF', ['tickets'=>$tickets, 'client'=>$client, 'sys_admin'=>$sys_admin, 'receipt'=>$receipt, 'taxsum'=>$taxsum, 'dateita'=>$dateita]);

                // Nome del file
                $filename = 'ricevuta_' .  $receipt->Numero . '_' . $receipt->Anno . '.pdf';

                // Ottieni il contenuto del PDF come stringa
                $pdfcontent = $pdf->output();

                // Salva il PDF nella directory privata "storage/app/private/"
                Storage::put('private/' . $filename, $pdfcontent);

                $pathpdf = ('app/private/' . $filename);
                
                return view('PreviewPDF', [
                    'pathpdf' => $pathpdf,
                    'receipt' => $receipt,
                    'client' => $client,
                    'sys_admin' => $sys_admin,
                    'tickets' => $ticketsArray,
                    'hourlyAmount' => $hourlyamount,
                    'withholdingTax' => $withholding_tax,
                    'taxsum' => $taxsum,
                    'dateita' => $dateita,
                ]);


                    }
                }
            
    

}
