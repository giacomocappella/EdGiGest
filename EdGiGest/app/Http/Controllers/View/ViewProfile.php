<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class ViewProfile extends Controller
{
    public function __invoke(Request $request){
          
        $userId = Auth::id();

        $user=User::findOrFail($userId);

        return view('Profile', ['user'=>$user]);
        
    }
}
