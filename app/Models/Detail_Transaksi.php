<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_Transaksi extends Model
{
    protected $fillable = [
        'no_struk',
        'kode_barang',
        'kuantitas_barang',
        'harga_total_barang',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaksi::class, 'no_struk', 'no_struk');
    }
}
