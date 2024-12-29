<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index() : View{
        //? get all kasir
        $kasirs = User::where('role', 'kasir')->latest()->paginate(10);

        //? render view with users
        return view('kasir.index', compact('kasirs'));
    }

    public function create() : View{
        return view('kasir.create');
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
            'role' => 'kasir'
        ]);

        // Redirect ke halaman kasir
        return redirect()->route('kasir.index')->with('success', 'Registrasi berhasil! Selamat datang!');
    }

    public function destroy($id)
    {
        // Find the user
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Redirect with success message
        return redirect()->route('kasir.index')->with('success', 'Kasir berhasil dihapus');
    }

    public function edit($id) : View{
        // Find the user
        $kasir = User::findOrFail($id);

        // Render view with user
        return view('kasir.edit', compact('kasir'));
    }

    public function update(Request $request, $id)
    {
        // Find the user
        $kasir = User::findOrFail($id);

        // Validasi inputan
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $kasir->id,
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
        $kasir->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $kasir->password,
        ]);

        // Redirect with success message
        return redirect()->route('kasir.index')->with('success', 'Kasir berhasil diupdate');
    }

}
