<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukController extends Controller{
    
    //* Menampilakan Semua Produk 
     public function index() : View{
        //get all products
        $produks = Produk::with('kategori')->latest()->paginate(10);

        //render view with products
        return view('produk.index', compact('produks'));
    }

    //* Menampilkan Form Tambah Produk    
    public function create() : View{
        //? get all categories
        $kategoris = Kategori::all(); // Mengambil semua data kategori dari database
        return view('produk.create', compact('kategoris')); // Meneruskan data ke view
    }

    //* query untuk menyimpan data produk
    public function store(Request $request): RedirectResponse{

        //? validate form
        $request->validate([
            'gambar'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama_barang'    => 'required|min:5|max:255',
            'deskripsi'      => 'required|min:10|max:1000',
            'harga'          => 'required|numeric|min:0|max:1000000',
            'harga'          => 'required|numeric',
            'stok'           => 'required|numeric',
            'kategori_id'    => 'required|exists:kategoris,id'
        ]);

        //? upload image
        $gambar = $request->file('gambar');
        $gambar->storeAs('public/produk', $gambar->hashName());

        //? create product
        Produk::create([
            'gambar'        => $gambar->hashName(),
            'nama_barang'   => $request->nama_barang,
            'deskripsi'     => $request->deskripsi,
            'harga'         => $request->harga,
            'stok'          => $request->stok,
            'kategori_id'   => $request->kategori_id
        ]);

        //? redirect to index
        return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

}
