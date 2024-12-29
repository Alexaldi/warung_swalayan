<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

//! Class ProdukController untuk mengelola data produk
class ProdukController extends Controller{
    
    //* Menampilakan Semua Produk 
     public function index() : View{
        //? get all products
        $produks = Produk::with('kategori')->latest()->paginate(10);

        //? render view with products
        return view('produk.index', compact('produks'));
    }

    //* Menampilkan Form Tambah Produk    
    public function create() : View{
        //? get all categories
        $kategoris = Kategori::all(); //? Mengambil semua data kategori dari database
        return view('produk.create', compact('kategoris')); //? Meneruskan data ke view
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

    //* Menampilkan Detail Produk
    public function show(string $id): View{
        //? specify the ID of the product you want to display
        $produk = Produk::with('kategori')->findOrFail($id);
        //? render view with product
        return view('produk.show', compact('produk'));
    }

    //* Menampilkan Form Edit Produk
    public function edit(string $id): View{
        //? get product by ID
        $product = Produk::findOrFail($id);

        //? get all categories
        $kategoris = Kategori::all();

        //? render view with product and categories
        return view('produk.edit', compact('product', 'kategoris'));
    }

    //* query untuk mengupdate data produk
    public function update(Request $request, $id): RedirectResponse{
        //? validate form
        $request->validate([
            'gambar'         => 'image|mimes:jpeg,jpg,png|max:2048',
            'nama_barang'    => 'required|min:5|max:255',
            'deskripsi'      => 'required|min:10|max:1000',
            'harga'          => 'required|numeric|min:0|max:1000000',
            'harga'          => 'required|numeric',
            'stok'           => 'required|numeric',
            'kategori_id'    => 'required|exists:kategoris,id'
        ]);

        //? get product by ID
        $produk = Produk::findOrFail($id);

        //? check if image is uploaded
        if ($request->hasFile('gambar')) {

            //? upload new gambar
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/produk', $gambar->hashName());

            //? delete old gambar
            Storage::delete('public/produk/'.$produk->gambar);

            //? update product with new image
            $produk->update([
                'gambar'        => $gambar->hashName(),
                'nama_barang'   => $request->nama_barang,
                'deskripsi'     => $request->deskripsi,
                'harga'         => $request->harga,
                'stok'          => $request->stok,
                'kategori_id'   => $request->kategori_id
            ]);

        } else {
            //? update product without image
            $produk->update([
                'nama_barang'   => $request->nama_barang,
                'deskripsi'     => $request->deskripsi,
                'harga'         => $request->harga,
                'stok'          => $request->stok,
                'kategori_id'   => $request->kategori_id
            ]);
        }

        //? redirect to index
        return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

     //* query untuk menghapus data produk
     public function destroy($id): RedirectResponse{
        //? get product by ID
        $produk = Produk::findOrFail($id);

        //? delete image
        Storage::delete('public/produk/'.$produk->gambar);

        //? delete produk
        $produk->delete();

        //? redirect to index
        return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}
