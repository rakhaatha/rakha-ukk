<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemTransaksi extends Model
{
    protected $fillable = ['transaksi_id', 'menu_id', 'jumlah', 'subtotal'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
