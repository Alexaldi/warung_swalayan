<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

class SessiController extends Controller
{
    function index(){
        return view('login');
    }

    function login(Request $request){
        $request-> validate([
            'email'=>'required',
            'password'=>'required'
        ],[
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi'
        ]);
    
        $infologin = [
            'email'=>$request->email,
            'password'=>$request->password
        ];

        //role redirect page
        if(Auth::attempt($infologin)){
            if (Auth::user()->role == 'kasir') {
                return redirect('home/kasir');
            }else if(Auth::user()->role == 'pelanggan'){
                return redirect('home/pelanggan');
            }
        }else{
            return redirect('')->withErrors('Username dan password salah')->withInput();
        }
    }
    
    function logout(){
        Auth::logout();
        return redirect('/');
    }
    
}
