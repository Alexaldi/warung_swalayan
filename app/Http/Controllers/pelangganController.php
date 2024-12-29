<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class pelangganController extends Controller
{
    public function index() : View{
        //? get all kasir
        $pelanggans = User::where('role', 'pelanggan')->latest()->paginate(10);
        //? render view with users
        return view('pelanggan.index', compact('pelanggans'));
    }

    public function create() : View{
        return view('pelanggan.create');
    }

     public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Email Tidak Valid',
            'email.unique' => 'Email Sudah Terdaftar',
            'password.required' => 'Password Wajib Diisi',
            'password.min' => 'Password Minimal 6 Karakter',
            'password.confirmed' => 'Konfirmasi Password Tidak Sesuai',
        ]);

        // Menyimpan data pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pelanggan'
        ]);

        // Redirect ke halaman pelanggan
        return redirect()->route('pelanggan.index')->with('success', 'Pembuatan akun berhasil! Selamat datang!');
    }

    public function destroy($id)
    {
        // Find the user
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Redirect with success message
        return redirect()->route('pelanggan.index')->with('success', 'pelanggan berhasil dihapus');
    }

    public function edit($id) : View
    {
        // Find the user
        $pelanggan = User::findOrFail($id);

        // Render view with user
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        // Find the user
        $pelanggan = User::findOrFail($id);

        // Validasi inputan
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pelanggan->id,
            'password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Email Tidak Valid',
            'email.unique' => 'Email Sudah Terdaftar',
            'password.min' => 'Password Minimal 6 Karakter',
            'password.confirmed' => 'Konfirmasi Password Tidak Sesuai',
        ]);
        // Update the user
        $pelanggan->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $pelanggan->password,
        ]);

        // Redirect with success message
        return redirect()->route('pelanggan.index')->with('success', 'pelanggan berhasil diupdate');
    }
}   

   