<?php

use App\Http\Controllers\KasirController;
use App\Http\Controllers\SessiController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/', [SessiController::class,'index'])->name('login');
    Route::post('/', [SessiController::class,'login']);
});

Route::middleware([Authenticate::class])->group(function () {
    Route::get("/admin",[KasirController::class,'index']);
    Route::get("/admin/pelanggan",[KasirController::class,'pelanggan'])->middleware('userAkses:pelanggan');
    Route::get("/admin/kasir",[KasirController::class,'kasir'])->middleware('userAkses:kasir');
    Route::get("/logout",[SessiController::class,'logout']);
});


