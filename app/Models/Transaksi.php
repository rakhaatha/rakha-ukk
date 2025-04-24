<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['tanggal', 'total_harga', 'metode_pembayaran'];


    public function items()
    {
        return $this->hasMany(ItemTransaksi::class);
    }
}
