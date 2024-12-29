<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::latest()->paginate(10);
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama Wajib Diisi',
            'name.unique' => 'Username Sudah Terdaftar',
            'password.required' => 'Password Wajib Diisi',
            'password.min' => 'Password Minimal 6 Karakter',
            'password.confirmed' => 'Konfirmasi Password Tidak Sesuai',
        ]);

        Admin::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil dibuat');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus');
    }


    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'Nama Wajib Diisi',
            'name.unique' => 'Username Sudah Terdaftar',
            'password.min' => 'Password Minimal 6 Karakter',
            'password.confirmed' => 'Konfirmasi Password Tidak Sesuai',
        ]);

        $admin = Admin::findOrFail($id);
        $admin->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diupdate');
    }
}
