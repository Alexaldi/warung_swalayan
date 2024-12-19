<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if(Auth::attempt($infologin)){
            return redirect('admin');
        }else{
            return redirect('')->withErrors('Username dan password salah')->withInput();
        }
    }
    
}
