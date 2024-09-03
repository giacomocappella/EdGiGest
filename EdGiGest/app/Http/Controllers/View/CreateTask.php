<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CreateTask extends Controller
{
    public function __invoke()
    {
        return view('NewTask');
    }
}
