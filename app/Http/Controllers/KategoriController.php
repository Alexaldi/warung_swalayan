<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller{

    //* Menampilakan Semua Kategori
    public function index() : View{
        //? get all products
        $kategoris = Kategori::latest()->paginate(10);

        //? render view with products
        return view('kategori.index', compact('kategoris'));
    }

    //* Menampilkan Form Tambah Kategori
    public function create() : View{
        //? get all categories
        $kategoris = Kategori::all(); //? Mengambil semua data kategori dari database
        return view('kategori.create'); //? Meneruskan data ke view
    }

    //* query untuk menyimpan data kategori
    public function store(Request $request): RedirectResponse{

        //? validate form
        $request->validate([
            'nama_kategori' => 'required|min:3|max:255',
        ]);

        //? create category
        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        //? redirect to index
        return redirect()->route('kategori.index')->with(['success' => 'Kategori Berhasil Disimpan!']);
    }

    //* Menampilkan Form Edit Kategori
    public function edit(string $id): View{
        //? get category by ID
        $kategori = Kategori::findOrFail($id);

        //? render view with category
        return view('kategori.edit', compact('kategori'));
    }

    //* query untuk mengupdate data kategori
    public function update(Request $request, string $id): RedirectResponse{
        //? validate form
        $request->validate([
            'nama_kategori' => 'required|min:3|max:255',
        ]);

        //? get category by ID
        $kategori = Kategori::findOrFail($id);

        //? update category
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        //? redirect to index
        return redirect()->route('kategori.index')->with(['success' => 'Kategori Berhasil Diubah!']);
    }

    //* query untuk menghapus data kategori
    public function destroy(string $id): RedirectResponse{
        //? get category by ID
        $kategori = Kategori::findOrFail($id);

        //? delete category
        $kategori->delete();

        //? redirect to index
        return redirect()->route('kategori.index')->with(['success' => 'Kategori Berhasil Dihapus!']);
    }
}
