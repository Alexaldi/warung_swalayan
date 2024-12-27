<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    //* Menampilakan Semua Transaksi 
     public function index() : View{
        //? get all products
        $transaksi = Transaksi::with(['kasir', 'member'])->latest()->paginate(10);
        //? render view with products
        return view('transaksi.index', compact('transaksi'));
    }
}
