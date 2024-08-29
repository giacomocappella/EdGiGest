<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class CreateClient extends Controller
{
    public function __invoke()
    {
        return view ('NewClient');
    }

}
