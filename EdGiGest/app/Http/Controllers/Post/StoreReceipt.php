<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Receipt;

class StoreReceipt extends Controller
{
    public function __invoke(Request $request)
{
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
}
