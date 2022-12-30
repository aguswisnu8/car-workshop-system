<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    static function sendMail(){
        $name = 'Admin';
        Mail::to('fake@email.com')->send(new NotificationMail($name));
        return view('welcome');
    }
}
