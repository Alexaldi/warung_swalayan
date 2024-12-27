<?php

use App\Http\Controllers\KasirController;
use App\Http\Controllers\SessiController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

//? Route ketika user sudah login. Maka akan diarahkan ke halaman home
Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/', [SessiController::class,'index'])->name('login');
    Route::post('/', [SessiController::class,'login']);
});

//? Route untuk semua request yang membutuhkan autentikasi
Route::middleware([Authenticate::class])->group(function () {
    //* Halaman Home
    Route::get("/home",[KasirController::class,'index']);
    //* Halaman ketika role Pelanggan login
    Route::get("/home/pelanggan",[KasirController::class,'pelanggan'])->middleware('userAkses:pelanggan');
    //* Halaman ketika role Kasir login
    Route::get("/home/kasir",[KasirController::class,'kasir'])->middleware('userAkses:kasir');
    //* method logout
    Route::get("/logout",[SessiController::class,'logout']);
    //* route untuk semua req produk
    Route::resource('/home/produk', \App\Http\Controllers\ProdukController::class);
});




