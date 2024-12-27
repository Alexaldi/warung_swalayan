<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{   

    function index(){
        echo "Halo,selamat Datang";
        echo "<h1>". Auth::user()->name ."</h1>";
        echo "<a href='logout'>Log Out</a>";
    }

    function kasir(){
        echo "Halo,selamat Datang Dihalaman Kasir";
        echo "<h1>". Auth::user()->name ."</h1>";
        echo "<a href='/logout'>Log Out</a>";
    }

    function pelanggan(){
        echo "Halo,Selamat Datang Dihalaman Pelanggan";
        echo "<h1>". Auth::user()->name ."</h1>";
        echo "<a href='/logout'>Log Out</a>";
    }
}
