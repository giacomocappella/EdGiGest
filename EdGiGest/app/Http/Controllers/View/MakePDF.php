<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MakePDF extends Controller
{
        public function download() {
        $data = [
            [
                'quantity' => 1,
                'description' => '1 Year Subscription',
                'price' => '129.00'
            ]
        ];
     
        $pdf = Pdf::loadView('ReceiptPDF', ['data' => $data]);
     
        return view('ReceiptPDF', ['data' => $data]);
    }
}
