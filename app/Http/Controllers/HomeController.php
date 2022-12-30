<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        
        $user = $request->session()->get('user');
        return response()->view('home.home',[
            'title' => 'Car Workshop',
            'user' => $user
        ]);
        
    }
}
