<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    
    protected $fillable = ['nama', 'harga', 'kategori','foto', 'stok'];

    public function user()
{
    return $this->belongsTo(User::class);
}

}

