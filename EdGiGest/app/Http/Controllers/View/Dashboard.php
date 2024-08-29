<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function __invoke()
    {
        return view ('welcome');
    }
}
