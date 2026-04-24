<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadXML extends Controller
{
    public function __invoke($filename){
        
        $path = "private/{$filename}";

        if (!Storage::exists($path)) {
            abort(404, 'File non trovato');
        }

        return Storage::download($path); 
        
    }
}
