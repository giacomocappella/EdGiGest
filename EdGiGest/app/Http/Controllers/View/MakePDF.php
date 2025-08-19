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
                $tickets=Ticket::whereIn('id', $idtickets)->get();

                //calcolo ore totali
                $durationhours = $tickets->sum('Ore_totali');

                //definisco l'importo orario
                $hourlyamount=30.00;

                //definisco la ritenuta d'acconto
                $withholding_tax=0.2;

                //ottengo l'anno corrente
                $anno=date('Y');

                //ottengo la data odierna che sarà la data della ricevuta
                $currentdate = Carbon::now()->format('Y/m/d');

                //trovo il sistemista nel db (attraverso l'id utente in futuro)
                $sys_admin=User::findOrFail($techid);

                //creazione nuova istanza ricevuta su database 
                //recupero l'ultima ricevuta nell'anno correte
                $lastreceipt = Receipt::where('Anno', $anno)
                                        ->where('CF_Sistemista', $sys_admin->CF)
                                        ->orderBy('Numero', 'desc')
                                        ->first();
                // Calcola il prossimo numero ricevuta
                if ($lastreceipt) {
                    $number = $lastreceipt->Numero + 1;
                } else {
                    $number = 1; // Se non esistono ricevute per l'anno corrente, si parte da 1
                }

                //trovo il cliente nel db
                $client=Client::findOrFail($idclient);



                $receipt = new Receipt();
                $receipt->Numero = $number;
                $receipt->Anno = $anno;
                $receipt->Data = $currentdate;
                $receipt->P_IVA_CF_Cliente = $client->Partita_IVA_CF;
                $receipt->CF_Sistemista = $sys_admin->CF;
                $receipt->Importo_Netto = ($durationhours*$hourlyamount);  //numero ore per importo orario
                $receipt->Importo_Lordo = ($receipt->Importo_Netto/(1-$withholding_tax));  //conversione netto-lordo con la ritenuta al 20%
                $taxsum=($receipt->Importo_Lordo-$receipt->Importo_Netto);

                //converto nuovamente la data per la ricevuta
                $dateita = Carbon::createFromFormat('Y/m/d', $receipt->Data)->format('d/m/Y');
                
                
                //crea il pdf con i dati inseriti
                $pdf = Pdf::loadView('ReceiptPDF', ['tickets'=>$tickets, 'client'=>$client, 'sys_admin'=>$sys_admin, 'receipt'=>$receipt, 'taxsum'=>$taxsum, 'dateita'=>$dateita]);

                // Nome del file
                $filename = 'ricevuta_' . $sys_admin->CF . '_' . $receipt->Numero . '_' . $receipt->Anno . '.pdf';

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
                    'tickets' => $tickets,
                    'hourlyAmount' => $hourlyamount,
                    'withholdingTax' => $withholding_tax,
                    'taxsum' => $taxsum,
                    'dateita' => $dateita,
                ]);


            }        
                
            
            //doppia ricevuta
            if($singolaric==false)
            {
                $idtickets=$request->input('selected_tickets');

                //se non viene selezionato alcun ticket, torna alla scelta dei clienti
                if($idtickets==null){
                    return redirect()->route('create.receipt');
                }

                //recupero l'id client per recuperare i dati dal database
                $idclient=$request->input('idclient');
               
                //recupero i tickets
                $tickets=Ticket::whereIn('id', $idtickets)->get();

                //calcolo ore totali
                $durationhours = $tickets->sum('Ore_totali');

                //definisco l'importo orario
                $hourlyamount=30.00;

                //definisco la ritenuta d'acconto
                $withholding_tax=0.2;

                //ottengo l'anno corrente
                $anno=date('Y');

                //ottengo la data odierna che sarà la data della ricevuta
                $currentdate = Carbon::now()->format('Y/m/d');

                // Ottiengo i tecnici dal database (solo quelli con partita IVA 0000000000)
                $technicians = User::where('current_team_id', '0000000000')->get();

                // Prendo i primi due tecnici dall'elenco
                $tech1 = $technicians[0];
                $tech2 = $technicians[1];

                // Trova il cliente nel database
                $client = Client::findOrFail($idclient);

                // Calcola le ore per tecnico (divise equamente)
                $halfHours = $durationhours / 2;

                // Itera per ogni tecnico e crea la ricevuta
                $receipts = []; // Array per salvare le ricevute
                $pdfPaths = []; // Array per salvare i percorsi dei PDF

                foreach ([$tech1, $tech2] as $tech) {
                    
                    // Recupera l'ultima ricevuta per l'anno corrente del tecnico
                    $lastReceipt = Receipt::where('Anno', $anno)
                                        ->where('CF_Sistemista', $tech->CF)
                                        ->orderBy('Numero', 'desc')
                                        ->first();

                    // Calcola il prossimo numero di ricevuta
                    $number = $lastReceipt ? $lastReceipt->Numero + 1 : 1;

                    // Calcola l'importo netto e lordo (basato sulle ore divise)
                    $importoNetto = ($halfHours * $hourlyamount);
                    $importoLordo = ($importoNetto / (1 - $withholding_tax));
                    $taxsum = ($importoLordo - $importoNetto);

                    // Crea la nuova ricevuta per il tecnico
                    $receipt = new Receipt();
                    $receipt->Numero = $number;
                    $receipt->Anno = $anno;
                    $receipt->Data = $currentdate;
                    $receipt->P_IVA_CF_Cliente = $client->Partita_IVA_CF;
                    $receipt->CF_Sistemista = $tech->CF;
                    $receipt->Importo_Netto = $importoNetto;
                    $receipt->Importo_Lordo = $importoLordo;
                    $receipt->Percorso_File = "app/private/ricevuta_{$tech->CF}_{$number}_{$anno}.pdf";

                    // Converti la data nel formato italiano
                    $dateita = Carbon::createFromFormat('Y/m/d', $receipt->Data)->format('d/m/Y');

                    // Genera il PDF per il tecnico
                    $pdf = Pdf::loadView('ReceiptPDF', [
                        'tickets' => $tickets,
                        'client' => $client,
                        'sys_admin' => $tech,
                        'receipt' => $receipt,
                        'taxsum' => $taxsum,
                        'dateita' => $dateita
                    ]);

                    // Salva il PDF
                    $filename = "ricevuta_{$tech->CF}_{$number}_{$anno}.pdf";
                    Storage::put("private/{$filename}", $pdf->output());

                    // Salva il percorso del PDF
                    $pdfPaths[] = "app/private/{$filename}";

                    // Aggiungi la ricevuta all'array
                    $receipts[] = $receipt;
                }

                // Passa i dati alla vista
                return view('PreviewPDF2tech', [
                    'pdfPaths' => $pdfPaths,
                    'receipts' => $receipts,
                    'client' => $client,
                    'sys_admins' => [$tech1, $tech2],
                    'tickets' => $tickets,
                    'hourlyAmount' => $hourlyamount,
                    'withholdingTax' => $withholding_tax,
                ]);


            }
        }
    }
        
                
            
    


