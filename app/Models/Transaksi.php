<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
     protected $fillable = [
        'no_struk',
        'tgl_struk',
        'jam_belanja',
        'id_kasir',
        'id_member',
        'total_item',
        'total_quantitas',
        'sub_total',
        'bayar',
        'kembalian',
    ];

    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir');
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'id_member');
    }

     public function items()
    {
        return $this->hasMany(Detail_Transaksi::class, 'no_struk', 'no_struk');
    }
}
