<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardReceipts extends Controller
{
    public function __invoke(){
        return view('DashboardReceipts');
    }
}
