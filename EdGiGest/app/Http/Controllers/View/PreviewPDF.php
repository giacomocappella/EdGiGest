<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreviewPDF extends Controller
{
    public function __invoke ($filename) {
        // Verifico se il file esiste nella cartella "storage/app/private"
        $file = storage_path('app/private/' . $filename);
    
        if (!file_exists($file)) {
            abort(404);  // Mostro errore 404 se il file non esiste
        }
        return response()->file($file);
    }
}
