<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    function index(){
        echo "Halo,Kasir";
        echo "<h1>". Auth::user()->name ."</h1>";
    }
}
