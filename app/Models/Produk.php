<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Produk extends Model{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'gambar',
        'deskripsi',
        'harga',
        'stok',
        'kategori_id'
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class);
    }


}
