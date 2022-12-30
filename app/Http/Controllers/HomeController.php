<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        
        //code...
        return session('user');
        
    }
}
