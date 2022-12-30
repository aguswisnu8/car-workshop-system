<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    

    public function login(): Response
    {
        return response()->view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function doLogin(Request $request): Response|RedirectResponse
    {

        $url = env('API_URL').'login';
        $response = Http::post($url,[
            'email' => $request->email,
            'password'=>$request->password
        ]);
        if ($response->status()==200) {
            $data =  $response->json()['data'];
            $token =  $response->json()['authorisation']['token'];

            $request->session()->put('user', $data);
            $request->session()->put('token', $token);
            return redirect('/');
        }
        return response()->view('auth.login', [
            'title' => 'Login',
            'error'=> 'Login failed'
        ]);
    }

    public function register(): Response
    {
        return response()->view('auth.register', [
            'title' => 'Register'
        ]);
    }

    public function doRegister(Request $request) : Response|RedirectResponse
    {
        $url = env('API_URL').'register';
        $response = Http::post($url,[
            'name' => $request->name,
            'email' => $request->email,
            'password'=>$request->password
        ]);
        if ($response->status()==200) {
            $data =  $response->json()['data'];
            $token =  $response->json()['authorisation']['token'];

            $request->session()->put('user', $data);
            $request->session()->put('token', $token);
            return redirect('/');
        }
        return response()->view('auth.register', [
            'title' => 'Register',
            'error'=> 'Register failed'
        ]);
        
    }

    public function doLogout(Request $request)
    {
        $request->session()->forget('user');
        return redirect('/login');
    }
}
