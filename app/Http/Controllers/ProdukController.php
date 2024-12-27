<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukController extends Controller
{
     public function index() : View
    {
        //get all products
        $produks = Produk::latest()->paginate(10);

        //render view with products
        return view('produk.index', compact('produks'));
    }
}
