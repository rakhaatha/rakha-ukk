<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'waiter_id',
        'status',
        'total_harga',
        'metode_pembayaran',
        'tanggal',
        'uang_dibayar',
        'kembalian',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

         public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    protected $casts = [
        'items' => 'array',
    ];
    
}
