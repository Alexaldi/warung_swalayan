<?php

use App\Http\Controllers\SessiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SessiController::class,'index']);
Route::post('/', [SessiController::class,'login']);