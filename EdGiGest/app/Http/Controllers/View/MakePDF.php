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
use App\Models\Invoice;

class MakePDF extends Controller
{
        public function __invoke(Request $request){
            //recupero la scelta di ricevuta singola o doppia
            $singolaric = $request->has('enable_technician'); 
            if($singolaric==true)
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
             
                //definisco l'importo orario dei tecnici
                $hourlyamount_occasionale = User::where('CF', 'CPPGCM95A17C111Q')
                    ->value('Costo_orario_netto');

                $hourlyamount_forfettario=User::where('CF', 'CRGDRD94S03C111U')
                    ->value('Costo_orario_netto');

                //definisco la ritenuta d'acconto
                $withholding_tax=0.2;

                //ottengo l'anno corrente
                $anno=date('Y');

                //ottengo la data odierna che sarà la data della ricevuta
                $currentdate = Carbon::now()->format('Y/m/d');

                // Ottiengo i tecnici dal database (solo quelli con partita IVA 0000000000)
                $tech = User::where('id', $request->input('technician_id'))->firstOrFail();

                // Trova il cliente nel database
                $client = Client::findOrFail($idclient);

                //inizializzo array
                $receipts = []; // Array per salvare le ricevute
                $invoices = []; // Array per salvare le fatture

                if($tech->Tipo_collab == 'Occasionale')
                    {
                        // Recupera l'ultima ricevuta per l'anno corrente del tecnico
                        $lastReceipt = Receipt::where('Anno', $anno)
                                            ->where('CF_Sistemista', $tech->CF)
                                            ->orderBy('Numero', 'desc')
                                            ->first();

                        // Calcola il prossimo numero di ricevuta
                        $number = $lastReceipt ? $lastReceipt->Numero + 1 : 1;

                        // Calcola l'importo netto e lordo (basato sulle ore divise)
                        $importoNetto = $durationhours * $hourlyamount_occasionale;
                        $importoLordo = $importoNetto / (1 - $withholding_tax);
                        $taxsum = $importoLordo - $importoNetto;


                        // Crea la nuova ricevuta per il tecnico
                        $receipt = new Receipt();
                        $receipt->Numero = $number;
                        $receipt->Anno = $anno;
                        $receipt->Data = $currentdate;
                        $receipt->P_IVA_CF_Cliente = $client->Partita_IVA_CF;
                        $receipt->CF_Sistemista = $tech->CF;
                        $receipt->Importo_Netto = $importoNetto;
                        $receipt->Importo_Lordo = $importoLordo;
                        $receipt->Percorso_File = "app/private/{$anno}_{$number}_{$tech->CF}_ricevuta.pdf";

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
                        $filename = "{$anno}_{$number}_{$tech->CF}_ricevuta.pdf";

                        Storage::put("private/{$filename}", $pdf->output());

                        // Salva il percorso del PDF
                        $pdfPaths = "app/private/{$filename}";

                        // Aggiungi la ricevuta all'array
                        $receipts[] = $receipt;

                        return view('PreviewPDF', [
                            'pathpdf' => $pdfPaths,
                            'receipt' => $receipts,
                            'client' => $client,
                            'tickets' => $tickets,
                            'sys_admin' => $tech,
                        ]);
                    }
                    
                    elseif($tech->Tipo_collab == 'Forfettario')
                    {
                       
                        $lastInvoice = Invoice::where('anno', $anno)
                                            ->where('sistemista_id', $tech->id)
                                            ->orderBy('numero', 'desc')
                                            ->first();

                        // Calcola il prossimo numero di fattura
                        $number = $lastInvoice ? $lastInvoice->numero + 1 : 1;

                        //progressivo invio
                        $yearShort = substr($anno, -2); 
                        $userletter = strtoupper(substr($tech->name, 0, 1)); 

                        $progressivo = $yearShort
                            . $userletter
                            . str_pad($number, 2, '0', STR_PAD_LEFT);

                        // Calcola l'importo 
                        $importo = $durationhours * $hourlyamount_forfettario;

                        // Splitto il nome per dopo
                        $parts = explode(' ', $tech->name);

                        $nome = $parts[0] ?? '';
                        $cognome = $parts[1] ?? '';

                        // Crea la nuova fattura
                        $invoice = new Invoice();
                        $invoice->numero = $number;
                        $invoice->anno = $anno;
                        $invoice->data_emissione = $currentdate;
                        $invoice->tipo_documento = 'TD01';
                        $invoice->progressivo_invio = $progressivo;
                        $invoice->client_id = $client->Partita_IVA_CF;
                        $invoice->sistemista_id = $tech->id;
                        $invoice->prezzo_totale = $importo;
                        $invoice->importo_totale = $importo * 1.04;
                        $invoice->aliquota_iva = '0.00';
                        $invoice->natura = 'N2.2';
                        $invoice->modalita_pagamento = 'MP05';
                        $invoice->data_scadenza = Carbon::parse($currentdate)->addDays(10)->format('Y/m/d');
                        $invoice->percorso_xml = "app/private/{$anno}_{$number}_{$tech->Partita_Iva}_fattura.xml";
                        $invoice->percorso_pdf = "app/private/{$anno}_{$number}_{$tech->Partita_Iva}_fattura.pdf";
                        $invoice->stato = "generata";

                        // Converti la data nel formato italiano
                        $dateita = Carbon::createFromFormat('Y/m/d', $invoice->data_emissione)->format('d/m/Y');

                        // Genera il PDF fattura di cortesia
                        $pdf = Pdf::loadView('InvoicePDF', [
                            'tickets' => $tickets,
                            'client' => $client,
                            'sys_admin' => $tech,
                            'invoice' => $invoice,
                            'dateita' => $dateita
                        ]);

                        // Salva il PDF
                        $filename = "{$anno}_{$number}_{$tech->Partita_Iva}_fattura.pdf";

                        Storage::put("private/{$filename}", $pdf->output());

                        // Salva il percorso del PDF
                        $pdfPaths = "app/private/{$filename}";

                        //Genera XML
                        $xml= view ('InvoiceXML', [
                            'invoice' => $invoice,
                            'client' => $client,
                            'tech' => $tech,
                            'nome' => $nome,
                            'cognome' => $cognome,
                        ])->render();

                        $filenameXml = "{$anno}_{$number}_{$tech->Partita_Iva}_fattura.xml";

                        Storage::put("private/{$filenameXml}", $xml);

                        $xmlPaths = "app/private/{$filenameXml}";

                        // Aggiungi la fattura all'array
                        $invoices[] = $invoice;

                        return view('PreviewPDF', [
                            'pathpdf' => $pdfPaths,
                            'xmlPath' => $xmlPaths,
                            'invoice' => $invoices,
                            'client' => $client,
                            'tickets' => $tickets,
                            'sys_admin' => $tech,
                        ]);
                    }
                         
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

                //importo le percentuali
                $giacomo_percent=$request->input('giacomo_percent');
                $edoardo_percent=$request->input('edoardo_percent');

                //calcolo le ore effettive per tecnico
                $giacomo_hours=$durationhours*$giacomo_percent/100;
                $edoardo_hours=$durationhours*$edoardo_percent/100;
                
                //definisco l'importo orario dei tecnici
                $hourlyamount_occasionale = User::where('CF', 'CPPGCM95A17C111Q')
                    ->value('Costo_orario_netto');

                $hourlyamount_forfettario=User::where('CF', 'CRGDRD94S03C111U')
                    ->value('Costo_orario_netto');

                //definisco la ritenuta d'acconto
                $withholding_tax=0.2;

                //ottengo l'anno corrente
                $anno=date('Y');

                //ottengo la data odierna che sarà la data della ricevuta
                $currentdate = Carbon::now()->format('Y/m/d');

                // Ottiengo i tecnici dal database (solo quelli con partita IVA 0000000000)
                $technicians = User::where('current_team_id', '0000000000')->get();

                // Trova il cliente nel database
                $client = Client::findOrFail($idclient);

                //inizializzo array
                $receipts = []; // Array per salvare le ricevute
                $pdfPaths = []; // Array per salvare i percorsi dei PDF
                $xmlPaths = []; // Array per salvare i percorsi degli XML
                $invoices = []; // Array per salvare le fatture

                foreach ($technicians as $tech) {
                    if($tech->Tipo_collab == 'Occasionale')
                    {
                        // Recupera l'ultima ricevuta per l'anno corrente del tecnico
                        $lastReceipt = Receipt::where('Anno', $anno)
                                            ->where('CF_Sistemista', $tech->CF)
                                            ->orderBy('Numero', 'desc')
                                            ->first();

                        // Calcola il prossimo numero di ricevuta
                        $number = $lastReceipt ? $lastReceipt->Numero + 1 : 1;

                        // Calcola l'importo netto e lordo (basato sulle ore divise)
                        $importoNetto = $giacomo_hours * $hourlyamount_occasionale;
                        $importoLordo = $importoNetto / (1 - $withholding_tax);
                        $taxsum = $importoLordo - $importoNetto;


                        // Crea la nuova ricevuta per il tecnico
                        $receipt = new Receipt();
                        $receipt->Numero = $number;
                        $receipt->Anno = $anno;
                        $receipt->Data = $currentdate;
                        $receipt->P_IVA_CF_Cliente = $client->Partita_IVA_CF;
                        $receipt->CF_Sistemista = $tech->CF;
                        $receipt->Importo_Netto = $importoNetto;
                        $receipt->Importo_Lordo = $importoLordo;
                        $receipt->Percorso_File = "app/private/{$anno}_{$number}_{$tech->CF}_ricevuta.pdf";

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
                        $filename = "{$anno}_{$number}_{$tech->CF}_ricevuta.pdf";

                        Storage::put("private/{$filename}", $pdf->output());

                        // Salva il percorso del PDF
                        $pdfPaths[] = "app/private/{$filename}";

                        // Aggiungi la ricevuta all'array
                        $receipts[] = $receipt;
                    }
                    
                    elseif($tech->Tipo_collab == 'Forfettario')
                    {
                       
                        $lastInvoice = Invoice::where('anno', $anno)
                                            ->where('sistemista_id', $tech->id)
                                            ->orderBy('numero', 'desc')
                                            ->first();

                        
                        // Calcola il prossimo numero di fattura
                        $number = $lastInvoice ? $lastInvoice->numero + 1 : 1;

                        //progressivo invio
                        $userletter=substr($tech->name, 0, 1);
                        $progressivo=$anno
                            . $userletter
                            . str_pad($number, 5, '0', STR_PAD_LEFT);

                        // Calcola l'importo 
                        $importo = $edoardo_hours * $hourlyamount_forfettario;

                        // Splitto il nome per dopo
                        $parts = explode(' ', $tech->name);

                        $nome = $parts[0] ?? '';
                        $cognome = $parts[1] ?? '';

                        // Crea la nuova fattura
                        $invoice = new Invoice();
                        $invoice->numero = $number;
                        $invoice->anno = $anno;
                        $invoice->data_emissione = $currentdate;
                        $invoice->tipo_documento = 'TD01';
                        $invoice->progressivo_invio = $progressivo;
                        $invoice->client_id = $client->Partita_IVA_CF;
                        $invoice->sistemista_id = $tech->id;
                        $invoice->prezzo_totale = $importo;
                        $invoice->importo_totale = $importo *1.04;
                        $invoice->aliquota_iva = '0.00';
                        $invoice->natura = 'N2.2';
                        $invoice->modalita_pagamento = 'MP05';
                        $invoice->data_scadenza = Carbon::parse($currentdate)->addDays(10)->format('Y/m/d');
                        $invoice->percorso_xml = "app/private/{$anno}_{$number}_{$tech->Partita_Iva}_fattura.xml";
                        $invoice->percorso_pdf = "app/private/{$anno}_{$number}_{$tech->Partita_Iva}_fattura.pdf";
                        $invoice->stato = "generata";

                        // Converti la data nel formato italiano
                        $dateita = Carbon::createFromFormat('Y/m/d', $invoice->data_emissione)->format('d/m/Y');

                        // Genera il PDF fattura di cortesia
                        $pdf = Pdf::loadView('InvoicePDF', [
                            'tickets' => $tickets,
                            'client' => $client,
                            'sys_admin' => $tech,
                            'invoice' => $invoice,
                            'dateita' => $dateita
                        ]);

                        // Salva il PDF
                        $filename = "{$anno}_{$number}_{$tech->Partita_Iva}_fattura.pdf";

                        Storage::put("private/{$filename}", $pdf->output());

                        // Salva il percorso del PDF
                        $pdfPaths[] = "app/private/{$filename}";

                        //Genera XML
                        $xml= view ('InvoiceXML', [
                            'invoice' => $invoice,
                            'client' => $client,
                            'tech' => $tech,
                            'nome' => $nome,
                            'cognome' => $cognome,
                        ])->render();

                        $filenameXml = "{$anno}_{$number}_{$tech->Partita_Iva}_fattura.xml";

                        Storage::put("private/{$filenameXml}", $xml);

                        $xmlPaths[] = "app/private/{$filenameXml}";

                        // Aggiungi la fattura all'array
                        $invoices[] = $invoice;
                    }
                                     
                }
                // Passa i dati alla vista
                return view('PreviewPDF2tech', [
                    'pdfPaths' => $pdfPaths,
                    'xmlPaths' => $xmlPaths,
                    'receipts' => $receipts,
                    'invoices' => $invoices,
                    'client' => $client,
                    'tickets' => $tickets,
                    'sys_admin' => $technicians,
                ]);


            }
        }
    }
        
                
            
    


