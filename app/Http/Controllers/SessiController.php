<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    //?Method register
    
    function register(){
        return view('register');
    }

    public function registerStore(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Email Tidak Valid',
            'email.unique' => 'Email Sudah Terdaftar',
            'password.required' => 'Password Wajib Diisi',
            'password.min' => 'Password Minimal 8 Karakter',
            'password.confirmed' => 'Konfirmasi Password Tidak Sesuai',
        ]);

        // Menyimpan data pengguna baru
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'pelanggan'; // Role default adalah pelanggan
        $user->save();
        // Login otomatis setelah registrasi jika diinginkan
        if ($request->has('login_after_register') && $request->login_after_register == 'yes') {
            Auth::login($user);
            return redirect('/home'); 
        }
        // Redirect ke halaman pelanggan
        return redirect()->route('/')->with('success', 'Registrasi berhasil! Selamat datang!');
    }
    
}
