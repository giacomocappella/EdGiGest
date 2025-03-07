<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreviewPDF2tech extends Controller
{
    public function __invoke($filename)
    {
    $filePath = storage_path('app/private/' . $filename);


    if (!file_exists($filePath)) {
        abort(404);  // Errore se il file non esiste
    }

    return response()->file($filePath);
    }

    
    
}
