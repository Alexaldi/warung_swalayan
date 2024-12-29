<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\SessiController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

//? Route ketika user sudah login. Maka akan diarahkan ke halaman home
Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/', [SessiController::class,'index'])->name('login');
    Route::post('/', [SessiController::class,'login']);
    Route::get('/register', [SessiController::class,'register'])->name('register');
    Route::post('/register', [SessiController::class,'registerStore']);
});

//? Route untuk semua request yang membutuhkan autentikasi
Route::middleware([Authenticate::class])->group(function () {
    //* Halaman Home
    Route::get("/home",[HomeController::class,'index']);
    //* Halaman ketika role Pelanggan login
    Route::get("/home/pelanggan",[HomeController::class,'pelanggan'])->middleware('userAkses:pelanggan');
    //* Halaman ketika role Kasir login
    Route::get("/home/kasir",[HomeController::class,'kasir'])->middleware('userAkses:kasir');
    //* method logout
    Route::get("/logout",[SessiController::class,'logout']);

    //* route untuk semua req produk
    Route::resource('/home/produk', \App\Http\Controllers\ProdukController::class);
    //* route untuk semua req transaksi
    Route::resource('/home/transaksi', \App\Http\Controllers\TransactionController::class);
    //* route untuk semua req kategori
    Route::resource('/home/kategori', \App\Http\Controllers\KategoriController::class);
});




