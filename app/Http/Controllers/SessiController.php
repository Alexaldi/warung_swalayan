<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessiController extends Controller{

    //? Method untuk menampilkan halaman login
    function index(){
        return view('login');
    }

    //? Method untuk proses login
    function login(Request $request){
        //* Validasi inputan
        $request-> validate([
            'email'=>'required',
            'password'=>'required'
        ],[
            'email.required' => 'Email Wajib Diisi',
            'password.required' => 'Password Wajib Diisi'
        ]);
        
        //* Data yang akan di cek
        $infologin = [
            'email'=>$request->email,
            'password'=>$request->password
        ];

        //? Jika login berhasil
        if(Auth::attempt($infologin)){
            //? Cek role user
            if (Auth::user()->role == 'kasir') {
                return redirect('home/kasir');
            }else if(Auth::user()->role == 'pelanggan'){
                return redirect('home/pelanggan');
            }
        }else{ //? Jika login gagal
            return redirect('')->withErrors('Username dan password salah')->withInput();
        }
    }
    
    //? Method untuk proses logout
    function logout(){
        Auth::logout();
        //? Redirect ke halaman login
        return redirect('/');
    }
    
}
